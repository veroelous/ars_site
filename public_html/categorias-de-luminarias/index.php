<?php
// As categorias agora ficam em /produtos/. Mantém links antigos funcionando (301).
header('Location: /produtos/', true, 301);
exit;
