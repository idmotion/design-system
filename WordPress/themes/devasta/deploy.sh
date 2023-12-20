#!/bin/bash
PROJECT_ROOT=$(dirname "$0")
API_DIR="$PROJECT_ROOT"

# Extrai a versão atual
OLD_VERSION=$(grep "'version'" $API_DIR/devasta-update-api.php | awk -F"'" '{print $4}')
echo "Versão antiga: $OLD_VERSION"

# Divide a versão em major, minor, patch
IFS='.' read -ra ADDR <<< "$OLD_VERSION"
MAJOR=${ADDR[0]}
MINOR=${ADDR[1]}
PATCH=${ADDR[2]}
echo "Major: $MAJOR, Minor: $MINOR, Patch: $PATCH"

# Incrementa a versão
PATCH=$((PATCH+1))
VERSION="${MAJOR}.${MINOR}.${PATCH}"
echo "Nova versão: $VERSION"

# Defina as variáveis

THEME_DIR="$PROJECT_ROOT/devasta"
SERVER="u871988871@82.180.153.97"

# Atualiza a versão no arquivo PHP da API
echo "<?php
\$data = array(
    'version' => '$VERSION',
    'download_url' => 'https://updates.idmotion.com.br/devasta/devasta-$VERSION.zip'
);
header('Content-Type: application/json');
echo json_encode(\$data);
?>" > "$API_DIR/devasta-update-api.php"

# Atualiza a versão no arquivo style.css
sed -i "s/Version: $OLD_VERSION/Version: $VERSION/" "$THEME_DIR/style.css"

# Empacota o tema
ZIP_DESTINATION="../devasta-$VERSION.zip"
cd $THEME_DIR
zip -r $ZIP_DESTINATION .
cd ..

# Copia o tema e o arquivo da API para o servidor
scp -P 65002 "devasta-$VERSION.zip" $SERVER:/home/u871988871/public_html/updates/devasta/
scp -P 65002 "devasta-update-api.php" $SERVER:/home/u871988871/public_html/updates/devasta/

echo "Deploy concluído!"