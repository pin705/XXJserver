<?php

namespace XXJ\Core;

class View
{
    public static function render(string $template, array $data = []): void
    {
        extract($data);
        $templatePath = __DIR__ . '/../../views/' . $template . '.php';
        if (file_exists($templatePath)) {
            require $templatePath;
        } else {
            // Fallback to old game/ folder if template not found (for gradual migration)
            $oldPath = __DIR__ . '/../../game/' . $template . '.php';
            if (file_exists($oldPath)) {
                require $oldPath;
            } else {
                echo "View not found: $template";
            }
        }
    }
}
