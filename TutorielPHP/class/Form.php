<?php

class Form {

    public static $class = 'form-control';

   
    public static function checkbox(string $name, ?string $value = null, array $data = []): string
    {
        $attributes = '';
        if (isset($data[$name]) && $data[$name] === $value) {
            $attributes .= ' checked';
        }
        $attributes .= ' class="' . self::$class . '"';

        return <<<HTML
<input type="checkbox" name="{$name}" value="{$value}"{$attributes}>
HTML;
    }

    public static function radio(string $name, string $value, array $data = []): string
    {
        $attributes = '';
        if (isset($data[$name]) && $data[$name] === $value) {
            $attributes .= ' checked';
        }
        $attributes .= ' class="' . self::$class . '"';

        return <<<HTML
<input type="radio" name="{$name}" value="{$value}"{$attributes}>
HTML;
    }

   
    public static function select(string $name, array $options = [], array $data = []): string
    {
        $htmlOptions = [];
        foreach ($options as $key => $value) {
            $attributes = '';
            if (isset($data[$name]) && $data[$name] === $key) {
                $attributes .= ' selected';
            }
            $htmlOptions[] = "<option value=\"{$key}\"{$attributes}>{$value}</option>";
        }
        return sprintf('<select name="%s" class="%s">%s</select>', $name, self::$class, implode('', $htmlOptions));
    }
}