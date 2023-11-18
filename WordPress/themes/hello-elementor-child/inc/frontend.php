<?php
// #I ou #Info para bloco de info //
function adicionar_classe_info($content) {
    // Expressão regular para encontrar parágrafos iniciados com "#I" ou "#Info"
    $pattern = '/(<p>|<li>)#(?:I|Info)\s*(.*?)(<\/p>|<\/li>)/i';
    
    // Aplica a substituição no conteúdo
    $content = preg_replace_callback($pattern, 'substituir_paragrafo_info', $content);
    
    return $content;
}

function substituir_paragrafo_info($matches) {
    // Remove o símbolo "#I" ou "#Info" e adiciona a classe CSS
    $replaced_content = preg_replace('/#(?:I|Info)\s*/i', '', $matches[2]);
    $replacement = '<p class="info">' . $replaced_content . '</p>';
    
    return $replacement;
}

add_filter('the_content', 'adicionar_classe_info');

// #D ou #Dica para bloco de dica //
function adicionar_classe_dica($content) {
    // Expressão regular para encontrar parágrafos iniciados com "#D" ou "#Dica"
    $pattern = '/(<p>|<li>)#(?:D|Dica)\s*(.*?)(<\/p>|<\/li>)/i';
    
    // Aplica a substituição no conteúdo
    $content = preg_replace_callback($pattern, 'substituir_paragrafo_dica', $content);
    
    return $content;
}

function substituir_paragrafo_dica($matches) {
    // Remove o símbolo "#D" ou "#Dica" e adiciona a classe CSS
    $replaced_content = preg_replace('/#(?:D|Dica)\s*/i', '', $matches[2]);
    $replacement = '<p class="dica">' . $replaced_content . '</p>';
    
    return $replacement;
}

add_filter('the_content', 'adicionar_classe_dica');

// #P ou #Perigo para bloco de perigo //
function adicionar_classe_paragrafo($content) {
    // Expressão regular para encontrar parágrafos iniciados com "#P" ou "#Perigo"
    $pattern = '/(<p>|<li>)#(?:P|Perigo)\s*(.*?)(<\/p>|<\/li>)/i';
    
    // Aplica a substituição no conteúdo
    $content = preg_replace_callback($pattern, 'substituir_paragrafo', $content);
    
    return $content;
}

function substituir_paragrafo($matches) {
    // Remove o símbolo "#P" ou "#Perigo" e adiciona a classe CSS
    $replaced_content = preg_replace('/#(?:P|Perigo)\s*/i', '', $matches[2]);
    $replacement = '<p class="perigo">' . $replaced_content . '</p>';
    
    return $replacement;
}

add_filter('the_content', 'adicionar_classe_paragrafo');

// #A ou #Aviso para bloco de aviso //
function adicionar_classe_aviso($content) {
    // Expressão regular para encontrar parágrafos iniciados com "#A" ou "#Aviso"
    $pattern = '/(<p>|<li>)#(?:A|Aviso)\s*(.*?)(<\/p>|<\/li>)/i';
    
    // Aplica a substituição no conteúdo
    $content = preg_replace_callback($pattern, 'substituir_paragrafo_aviso', $content);
    
    return $content;
}

function substituir_paragrafo_aviso($matches) {
    // Remove o símbolo "#A" ou "#Aviso" e adiciona a classe CSS
    $replaced_content = preg_replace('/#(?:A|Aviso)\s*/i', '', $matches[2]);
    $replacement = '<p class="aviso">' . $replaced_content . '</p>';
    
    return $replacement;
}

add_filter('the_content', 'adicionar_classe_aviso');

// > para ícone SVG //
function replace_greater_than_with_svg($content) {
    if (is_single()) {
        $svg_arrow = '<span style="padding-left: 3px; padding-right: 3px;"><svg fill="currentColor" width="14" height="14" viewBox="0 1 24 24" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;"><path d="M6.115 20.23 7.885 22l10-10-10-10-1.77 1.77 8.23 8.23-8.23 8.23Z"></path></svg></span>';
        
        $content = preg_replace_callback('/<(p|li)>(.*?)<\/(p|li)>/s', function ($matches) use ($svg_arrow) {
            return str_replace(' > ', $svg_arrow, $matches[0]);
        }, $content);
    }
    return $content;
}
add_filter('the_content', 'replace_greater_than_with_svg');

// Substituir hífen - e maior > por seta //
function replace_arrow_with_custom_svg($content) {
    $svg_arrow = '<svg style="vertical-align: -3px;" width="16" height="16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12s4.48 10 10 10 10-4.48 10-10ZM4 12c0-4.42 3.58-8 8-8s8 3.58 8 8-3.58 8-8 8-8-3.58-8-8Zm12 0-4 4-1.41-1.41L12.17 13H8v-2h4.17l-1.59-1.59L12 8l4 4Z"></path></svg>';
    return str_replace(' -> ', $svg_arrow, $content);
}

add_filter('the_content', 'replace_arrow_with_custom_svg');
add_filter('the_excerpt', 'replace_arrow_with_custom_svg');
add_filter('the_title', 'replace_arrow_with_custom_svg');

// Tempo de leitura estimado
function reading_time() {
$content = get_post_field( 'post_content', $post->ID );
$word_count = str_word_count( strip_tags( $content ) );
$readingtime = ceil($word_count / 260);
if ($readingtime == 1) {
$timer = " min";
} else {
$timer = " min";
}
$totalreadingtime = $readingtime . $timer;
return $totalreadingtime;
}
add_shortcode('wpbread', 'reading_time');

/* Disable WordPress Admin Bar for all users */
add_filter( 'show_admin_bar', '__return_false' );