<?php
// Bloco de quadro //
add_action('init', 'register_quadro_bloco');

function register_quadro_bloco() {
    // Estilos personalizados para o bloco no editor
    $editor_css = '.quadro { background-color: #fafafa; padding: 15px; border-radius: 5px; border: 1px solid #e0e0e0; }';
    wp_add_inline_style('wp-edit-blocks', $editor_css);

    // Registra o script principal do bloco.
    wp_register_script(
        'quadro-script',
        '', // Nenhum arquivo externo, o JS será embutido.
        array('wp-blocks', 'wp-element', 'wp-editor')
    );

    // Incorpora o JavaScript do bloco no script registrado.
    $block_js = <<<JS
        (function(wp) {
            var registerBlockType = wp.blocks.registerBlockType;
            var InnerBlocks = wp.blockEditor.InnerBlocks;

            registerBlockType('quadro/quadro', {
                title: 'Quadro',
                description: 'Use o Quadro para dar exemplos ou destacar informações de texto mais longas.',
                icon: 'format-aside',
                category: 'common',
                edit: function(props) {
                    return wp.element.createElement(
                        "div",
                        { className: "quadro" },
                        wp.element.createElement(InnerBlocks)
                    );
                },
                save: function() {
                    return wp.element.createElement(
                        "div",
                        { className: "quadro" },
                        wp.element.createElement(InnerBlocks.Content)
                    );
                }
            });
        })(window.wp);
JS;

    wp_add_inline_script('quadro-script', $block_js);

    // Registra o bloco.
    register_block_type('quadro/quadro', array(
        'editor_script' => 'quadro-script'
    ));
}

// Bloco de informação //
add_action('init', 'register_info_bloco');

function register_info_bloco() {
    // Estilos personalizados para o bloco no editor
    $editor_css = '.info { border: 1px solid blue; padding: 15px; border-radius: 5px; }';
    wp_add_inline_style('wp-edit-blocks', $editor_css);

    // Registra o script principal do bloco.
    wp_register_script(
        'info-script',
        '', // Nenhum arquivo externo, o JS será embutido.
        array('wp-blocks', 'wp-element', 'wp-editor')
    );

    // Incorpora o JavaScript do bloco no script registrado.
    $block_js = <<<JS
        (function(wp) {
            var registerBlockType = wp.blocks.registerBlockType;
            var RichText = wp.blockEditor.RichText;

            registerBlockType('info/info', {
                title: 'Informação',
                description: 'Forneça dados adicionais, esclarecimentos ou contextos relevantes sobre o conteúdo.',
                icon: 'editor-help',
                category: 'common',
                attributes: {
                    content: {
                        type: 'string',
                        source: 'html',
                        selector: 'p',
                    }
                },
                edit: function(props) {
                    return wp.element.createElement(
                        RichText,
                        {
                            tagName: "p",
                            className: "info",
                            value: props.attributes.content,
                            onChange: function(content) {
                                props.setAttributes({ content: content });
                            }
                        }
                    );
                },
				transforms: {
        from: [
            {
                type: 'block',
                blocks: ['core/paragraph'],
                transform: function(attributes) {
                    return wp.blocks.createBlock('info/info', {
                        content: attributes.content
                    });
                }
            }
        ],
        to: [
            {
                type: 'block',
                blocks: ['core/paragraph'],
                transform: function(attributes) {
                    return wp.blocks.createBlock('core/paragraph', {
                        content: attributes.content
                    });
                }
            }
        ]
    },
                save: function(props) {
                    return wp.element.createElement(
                        RichText.Content,
                        {
                            tagName: "p",
                            className: "info",
                            value: props.attributes.content
                        }
                    );
                }
            });
        })(window.wp);
JS;

    wp_add_inline_script('info-script', $block_js);

    // Registra o bloco.
    register_block_type('info/info', array(
        'editor_script' => 'info-script'
    ));
}

// Bloco de aviso //
add_action('init', 'register_aviso_bloco');

function register_aviso_bloco() {
    // Estilos personalizados para o bloco no editor
    $editor_css = '.aviso { border: 1px solid yellow; padding: 15px; border-radius: 5px; }';
    wp_add_inline_style('wp-edit-blocks', $editor_css);

    // Registra o script principal do bloco.
    wp_register_script(
        'aviso-script',
        '', // Nenhum arquivo externo, o JS será embutido.
        array('wp-blocks', 'wp-element', 'wp-editor')
    );

    // Incorpora o JavaScript do bloco no script registrado.
    $block_js = <<<JS
        (function(wp) {
            var registerBlockType = wp.blocks.registerBlockType;
            var RichText = wp.blockEditor.RichText;

            registerBlockType('aviso/aviso', {
                title: 'Aviso',
                description: 'Destaque mensagens de precaução ou alertas.',
                icon: 'editor-help',
                category: 'common',
                attributes: {
                    content: {
                        type: 'string',
                        source: 'html',
                        selector: 'p',
                    }
                },
                edit: function(props) {
                    return wp.element.createElement(
                        RichText,
                        {
                            tagName: "p",
                            className: "aviso",
                            value: props.attributes.content,
                            onChange: function(content) {
                                props.setAttributes({ content: content });
                            }
                        }
                    );
                },
				transforms: {
        from: [
            {
                type: 'block',
                blocks: ['core/paragraph'],
                transform: function(attributes) {
                    return wp.blocks.createBlock('aviso/aviso', {
                        content: attributes.content
                    });
                }
            }
        ],
        to: [
            {
                type: 'block',
                blocks: ['core/paragraph'],
                transform: function(attributes) {
                    return wp.blocks.createBlock('core/paragraph', {
                        content: attributes.content
                    });
                }
            }
        ]
    },
                save: function(props) {
                    return wp.element.createElement(
                        RichText.Content,
                        {
                            tagName: "p",
                            className: "aviso",
                            value: props.attributes.content
                        }
                    );
                }
            });
        })(window.wp);
JS;

    wp_add_inline_script('aviso-script', $block_js);

    // Registra o bloco.
    register_block_type('aviso/aviso', array(
        'editor_script' => 'aviso-script'
    ));
}

// Bloco de Dica //
add_action('init', 'register_dica_bloco');

function register_dica_bloco() {
    // Estilos personalizados para o bloco no editor
    $editor_css = '.dica { border: 1px solid purple; padding: 15px; border-radius: 5px; }';
    wp_add_inline_style('wp-edit-blocks', $editor_css);

    // Registra o script principal do bloco.
    wp_register_script(
        'dica-script',
        '', // Nenhum arquivo externo, o JS será embutido.
        array('wp-blocks', 'wp-element', 'wp-editor')
    );

    // Incorpora o JavaScript do bloco no script registrado.
    $block_js = <<<JS
        (function(wp) {
            var registerBlockType = wp.blocks.registerBlockType;
            var RichText = wp.blockEditor.RichText;

            registerBlockType('dica/dica', {
                title: 'Dica',
                description: 'Dê uma dica, conselhos, sugestões ou truques úteis sobre o conteúdo.',
                icon: 'lightbulb',
                category: 'common',
                attributes: {
                    content: {
                        type: 'string',
                        source: 'html',
                        selector: 'p',
                    }
                },
                edit: function(props) {
                    return wp.element.createElement(
                        RichText,
                        {
                            tagName: "p",
                            className: "dica",
                            value: props.attributes.content,
                            onChange: function(content) {
                                props.setAttributes({ content: content });
                            }
                        }
                    );
                },
				transforms: {
        from: [
            {
                type: 'block',
                blocks: ['core/paragraph'],
                transform: function(attributes) {
                    return wp.blocks.createBlock('dica/dica', {
                        content: attributes.content
                    });
                }
            }
        ],
        to: [
            {
                type: 'block',
                blocks: ['core/paragraph'],
                transform: function(attributes) {
                    return wp.blocks.createBlock('core/paragraph', {
                        content: attributes.content
                    });
                }
            }
        ]
    },
                save: function(props) {
                    return wp.element.createElement(
                        RichText.Content,
                        {
                            tagName: "p",
                            className: "dica",
                            value: props.attributes.content
                        }
                    );
                }
            });
        })(window.wp);
JS;

    wp_add_inline_script('dica-script', $block_js);

    // Registra o bloco.
    register_block_type('dica/dica', array(
        'editor_script' => 'dica-script'
    ));
}

// Novo bloco de Perigo //
add_action('init', 'register_perigo_bloco');

function register_perigo_bloco() {
    // Estilos personalizados para o bloco no editor
    $editor_css = '.perigo { border: 1px solid red; padding: 15px; border-radius: 5px; }';
    wp_add_inline_style('wp-edit-blocks', $editor_css);

    // Registra o script principal do bloco.
    wp_register_script(
        'perigo-script',
        '', // Nenhum arquivo externo, o JS será embutido.
        array('wp-blocks', 'wp-element', 'wp-editor')
    );

    // Incorpora o JavaScript do bloco no script registrado.
    $block_js = <<<JS
        (function(wp) {
            var registerBlockType = wp.blocks.registerBlockType;
            var RichText = wp.blockEditor.RichText;

            registerBlockType('perigo/perigo', {
                title: 'Perigo',
                description: 'Bloco designado para assinalar situações de risco iminentes.',
                icon: 'warning',
                category: 'common',
                attributes: {
                    content: {
                        type: 'string',
                        source: 'html',
                        selector: 'p',
                    }
                },
                edit: function(props) {
                    return wp.element.createElement(
                        RichText,
                        {
                            tagName: "p",
                            className: "perigo",
                            value: props.attributes.content,
                            onChange: function(content) {
                                props.setAttributes({ content: content });
                            }
                        }
                    );
                },
				transforms: {
        from: [
            {
                type: 'block',
                blocks: ['core/paragraph'],
                transform: function(attributes) {
                    return wp.blocks.createBlock('perigo/perigo', {
                        content: attributes.content
                    });
                }
            }
        ],
        to: [
            {
                type: 'block',
                blocks: ['core/paragraph'],
                transform: function(attributes) {
                    return wp.blocks.createBlock('core/paragraph', {
                        content: attributes.content
                    });
                }
            }
        ]
    },
                save: function(props) {
                    return wp.element.createElement(
                        RichText.Content,
                        {
                            tagName: "p",
                            className: "perigo",
                            value: props.attributes.content
                        }
                    );
                }
            });
        })(window.wp);
JS;

    wp_add_inline_script('perigo-script', $block_js);

    // Registra o bloco.
    register_block_type('perigo/perigo', array(
        'editor_script' => 'perigo-script'
    ));
}

// Bloco Link Externo //
add_action('init', 'register_link_externo_bloco');

function register_link_externo_bloco() {
    // Estilos personalizados para o bloco no editor
    $editor_css = '.link-externo-class { border: 1px solid blue; padding: 15px; border-radius: 5px; display: block; margin-bottom: 10px; }';
    wp_add_inline_style('wp-edit-blocks', $editor_css);

    // Registra o script principal do bloco.
    wp_register_script(
        'link-externo-script',
        '', // Nenhum arquivo externo, o JS será embutido.
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-block-editor')
    );

    // Incorpora o JavaScript do bloco no script registrado.
    $block_js = <<<JS
        (function(wp) {
            var registerBlockType = wp.blocks.registerBlockType;
            var RichText = wp.blockEditor.RichText;
            var URLInputButton = wp.blockEditor.URLInputButton;

            registerBlockType('link-externo/link-externo', {
                title: 'Link externo',
                description: 'Use este bloco para destacar um link externo.',
                icon: 'external',
                category: 'common',
                attributes: {
                    content: {
                        type: 'string',
                        source: 'html',
                        selector: 'a',
                    },
                    url: {
                        type: 'string',
                        default: '#'
                    }
                },
                edit: function(props) {
                    return [
                        wp.element.createElement(
                            RichText,
                            {
                                tagName: "a",
                                className: "link-externo-class",
                                value: props.attributes.content,
                                onChange: function(content) {
                                    props.setAttributes({ content: content });
                                },
								allowedFormats: [],
                                href: props.attributes.url
                            }
                        ),
                        wp.element.createElement(
                            URLInputButton,
                            {
                                url: props.attributes.url,
                                onChange: function(url) {
								if (!url.startsWith('http://') && !url.startsWith('https://')) {
										url = 'https://' + url;
									}
                                    props.setAttributes({ url: url });
                                }
                            }
                        )
                    ];
                },
                save: function(props) {
                    return wp.element.createElement(
                        RichText.Content,
                        {
                            tagName: "a",
                            className: "link-externo-class",
                            value: props.attributes.content,
                            href: props.attributes.url
                        }
                    );
                }
            });
        })(window.wp);
JS;

    wp_add_inline_script('link-externo-script', $block_js);

    // Registra o bloco.
    register_block_type('link-externo/link-externo', array(
        'editor_script' => 'link-externo-script'
    ));
}