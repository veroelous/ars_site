/* ARS Iluminação — scripts do site (JavaScript puro, sem dependências). */
(function () {
  "use strict";

  /* Eventos de medição: vão para o GA4 quando ele estiver configurado. */
  function track(event, params) {
    if (typeof window.gtag === "function") {
      window.gtag("event", event, params || {});
    } else {
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push(Object.assign({ event: event }, params || {}));
    }
  }

  document.addEventListener("click", function (ev) {
    var link = ev.target.closest && ev.target.closest("[data-track='whatsapp']");
    if (link) track("whatsapp_click", { page: location.pathname });
  });

  /* ---------- Máscara de WhatsApp: (00) 00000-0000 ---------- */
  function maskPhone(value) {
    var d = value.replace(/\D+/g, "").slice(0, 11);
    if (d.length <= 2) return d.length ? "(" + d : "";
    if (d.length <= 6) return "(" + d.slice(0, 2) + ") " + d.slice(2);
    if (d.length <= 10) return "(" + d.slice(0, 2) + ") " + d.slice(2, 6) + "-" + d.slice(6);
    return "(" + d.slice(0, 2) + ") " + d.slice(2, 7) + "-" + d.slice(7);
  }

  document.querySelectorAll("input[name='whatsapp']").forEach(function (input) {
    input.addEventListener("input", function () {
      input.value = maskPhone(input.value);
    });
  });

  document.querySelectorAll("input[name='cnpj']").forEach(function (input) {
    input.addEventListener("input", function () {
      var d = input.value.replace(/\D+/g, "").slice(0, 14);
      var out = d.slice(0, 2);
      if (d.length > 2) out += "." + d.slice(2, 5);
      if (d.length > 5) out += "." + d.slice(5, 8);
      if (d.length > 8) out += "/" + d.slice(8, 12);
      if (d.length > 12) out += "-" + d.slice(12);
      input.value = out;
    });
  });

  /* ---------- Validação (as mesmas regras do servidor) ---------- */
  function validWhatsapp(value) {
    var d = value.replace(/\D+/g, "");
    if (d.length >= 12 && d.indexOf("55") === 0) d = d.slice(2);
    if (d.length !== 10 && d.length !== 11) return false;
    var ddd = parseInt(d.slice(0, 2), 10);
    if (ddd < 11 || ddd > 99) return false;
    return d.length === 10 || d.charAt(2) === "9";
  }

  function validCnpj(value) {
    var d = value.replace(/\D+/g, "");
    if (d.length !== 14 || /^(\d)\1{13}$/.test(d)) return false;
    for (var len = 12; len <= 13; len++) {
      var sum = 0, weight = len - 7;
      for (var i = 0; i < len; i++) {
        sum += parseInt(d.charAt(i), 10) * weight--;
        if (weight < 2) weight = 9;
      }
      var digit = sum % 11 < 2 ? 0 : 11 - (sum % 11);
      if (parseInt(d.charAt(len), 10) !== digit) return false;
    }
    return true;
  }

  function validate(form) {
    var errors = {};
    var f = form.elements;
    if (f.nome.value.trim().length < 2) errors.nome = "Informe seu nome.";
    if (!validWhatsapp(f.whatsapp.value)) errors.whatsapp = "Informe um WhatsApp válido com DDD.";
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(f.email.value.trim())) errors.email = "Informe um e-mail válido.";
    var kind = form.dataset.kind;
    if (kind === "contato" && f.mensagem.value.trim().length < 5) errors.mensagem = "Conte brevemente o que você precisa.";
    if (kind === "revendedor") {
      if (f.empresa.value.trim().length < 2) errors.empresa = "Informe o nome da empresa.";
      if (f.cnpj.value.trim() && !validCnpj(f.cnpj.value)) errors.cnpj = "Confira o CNPJ (14 números).";
      if (f.cidade.value.trim().length < 2) errors.cidade = "Informe a cidade.";
      if (!f.uf.value) errors.uf = "Selecione o estado.";
      if (!f.perfil.value) errors.perfil = "Selecione o tipo de negócio.";
    }
    if (!f.consentimento.checked) {
      errors.consentimento = {
        catalogo: "É preciso autorizar o contato para liberar o catálogo.",
        revendedor: "É preciso autorizar o contato para enviar o cadastro."
      }[kind] || "É preciso autorizar o contato para enviar a mensagem.";
    }
    return errors;
  }

  function clearErrors(form) {
    form.querySelectorAll(".field__error").forEach(function (el) { el.remove(); });
    form.querySelectorAll(".field--error").forEach(function (el) { el.classList.remove("field--error"); });
    form.querySelectorAll("[aria-invalid]").forEach(function (el) {
      el.removeAttribute("aria-invalid");
      el.removeAttribute("aria-describedby");
    });
  }

  function showErrors(form, errors) {
    var first = null;
    Object.keys(errors).forEach(function (name) {
      var input = form.elements[name];
      if (!input) return;
      var wrap = input.closest(".field, .consent");
      var msg = document.createElement("p");
      msg.className = "field__error";
      msg.id = input.id + "-err";
      msg.textContent = errors[name];
      wrap.classList.add("field--error");
      wrap.appendChild(msg);
      input.setAttribute("aria-invalid", "true");
      input.setAttribute("aria-describedby", msg.id);
      if (!first) first = input;
    });
    if (first) first.focus();
  }

  /* ---------- Filtro de revendas por estado ---------- */
  var ufFilter = document.querySelector(".js-uf-filter");
  if (ufFilter) {
    ufFilter.addEventListener("change", function () {
      document.querySelectorAll(".resellers[data-uf]").forEach(function (block) {
        block.hidden = ufFilter.value !== "" && block.dataset.uf !== ufFilter.value;
      });
    });
  }

  /* ---------- Envio dos formulários ---------- */
  document.querySelectorAll(".js-lead-form").forEach(function (form) {
    var status = form.querySelector(".form-status");
    var button = form.querySelector("button[type='submit']");
    var buttonHtml = button.innerHTML;

    form.addEventListener("submit", function (ev) {
      ev.preventDefault();
      clearErrors(form);
      status.textContent = "";

      var errors = validate(form);
      if (Object.keys(errors).length) {
        showErrors(form, errors);
        status.textContent = "Confira os campos destacados.";
        return;
      }

      var data = {};
      new FormData(form).forEach(function (value, key) { data[key] = value; });
      data.consentimento = form.elements.consentimento.checked;

      button.disabled = true;
      button.textContent = "Enviando…";

      fetch(form.action, {
        method: "POST",
        headers: { "Content-Type": "application/json", Accept: "application/json" },
        body: JSON.stringify(data),
        credentials: "same-origin"
      })
        .then(function (res) {
          return res.json().catch(function () { return { ok: false }; });
        })
        .then(function (json) {
          if (!json.ok) {
            if (json.errors) showErrors(form, json.errors);
            status.textContent = json.message || "Não foi possível enviar agora. Tente novamente.";
            return;
          }
          track("generate_lead", { form: form.dataset.kind, page: location.pathname });

          if (form.dataset.kind === "catalogo") {
            var card = form.closest(".catalog-card");
            card.querySelector(".catalog-card__form").hidden = true;
            card.querySelector(".catalog-card__success").hidden = false;
            if (json.downloadUrl) {
              card.querySelector(".js-download-again").href = json.downloadUrl;
              track("catalog_download", { page: location.pathname });
              window.location.assign(json.downloadUrl);
            }
          } else {
            form.hidden = true;
            var ok = form.parentNode.querySelector(".contact-success");
            ok.hidden = false;
            ok.setAttribute("tabindex", "-1");
            ok.focus();
          }
        })
        .catch(function () {
          status.textContent = "Não foi possível enviar agora. Verifique sua conexão e tente novamente.";
        })
        .finally(function () {
          button.disabled = false;
          button.innerHTML = buttonHtml;
        });
    });
  });
})();
