<?php

if (! function_exists('sanitize_html')) {
    /**
     * Sanitizes HTML content for production-ready rich text display.
     * Enforces strict whitelist of tags and attributes.
     */
    function sanitize_html($html)
    {
        if (empty($html)) return '';

        // Initialize DOMDocument
        $dom = new DOMDocument();
        // Use libxml_use_internal_errors to suppress warnings on invalid HTML
        libxml_use_internal_errors(true);
        
        // Wrap in a div to ensure valid root and preserve encoding
        $html = '<div>' . mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8') . '</div>';
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $allowedTags = ['p', 'b', 'i', 'ul', 'li', 'a', 'img', 'iframe', 'div'];
        
        // Recursively clean the DOM
        $cleanNode = function($node) use (&$cleanNode, $allowedTags) {
            if ($node->nodeType === XML_ELEMENT_NODE) {
                // Check if tag is allowed
                if (!in_array(strtolower($node->nodeName), $allowedTags)) {
                    $node->parentNode->removeChild($node);
                    return;
                }

                // Clean attributes
                $attrs = [];
                foreach ($node->attributes as $attr) {
                    $attrs[] = $attr->nodeName;
                }

                foreach ($attrs as $attrName) {
                    $attrLower = strtolower($attrName);
                    $attrValue = strtolower($node->getAttribute($attrName));

                    // Block all event handlers (on*)
                    if (strpos($attrLower, 'on') === 0) {
                        $node->removeAttribute($attrName);
                        continue;
                    }

                    // Special rules for <a>
                    if ($node->nodeName === 'a') {
                        if ($attrLower !== 'href' && $attrLower !== 'title' && $attrLower !== 'target') {
                            $node->removeAttribute($attrName);
                        } elseif (preg_match('/^(javascript|data|vbscript):/i', trim($attrValue))) {
                            $node->removeAttribute($attrName);
                        } elseif ($attrLower === 'target' && $attrValue === '_blank') {
                            $node->setAttribute('rel', 'noopener noreferrer');
                        } elseif ($attrLower === 'target' && $attrValue !== '_blank') {
                            $node->setAttribute('target', '_self');
                        }
                    }

                    // Special rules for <img>
                    if ($node->nodeName === 'img') {
                        if ($attrLower !== 'src' && $attrLower !== 'alt' && $attrLower !== 'title') {
                            $node->removeAttribute($attrName);
                        } elseif (preg_match('/^(javascript|data|vbscript):/i', trim($attrValue))) {
                            $node->removeAttribute($attrName);
                        }
                    }

                    // Special rules for <iframe>
                    if ($node->nodeName === 'iframe') {
                        if ($attrLower !== 'src' && $attrLower !== 'width' && $attrLower !== 'height' && $attrLower !== 'allowfullscreen' && $attrLower !== 'title') {
                            $node->removeAttribute($attrName);
                        } elseif ($attrLower === 'src') {
                            // Strict YouTube Regex Bypass Prevention
                            if (!preg_match('/^https:\/\/(www\.)?(youtube\.com\/embed\/|youtu\.be\/)/i', $attrValue)) {
                                $node->removeAttribute($attrName);
                            }
                        }
                    }
                }
            }

            if ($node->hasChildNodes()) {
                $children = iterator_to_array($node->childNodes);
                foreach ($children as $child) {
                    $cleanNode($child);
                }
            }
        };

        $cleanNode($dom->documentElement);
        
        // Get content inside our wrapper div
        $result = '';
        foreach ($dom->documentElement->childNodes as $child) {
            $result .= $dom->saveHTML($child);
        }

        return $result;
    }
}
