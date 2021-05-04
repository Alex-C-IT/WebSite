<?php 

namespace App\HTML;

use App\HTML\Exceptions\TableEmptyException;

class Form 
{
    private $data;
    private $errors;

    public function __construct($data, array $errors)
    {
        if(empty($data)) {
            throw new TableEmptyException();
        }
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $titre) : string
    {
        $value = $this->getValue($key);
        $type = $key === 'password' ? 'password' : 'text';
        return<<<HTML
        <div class="form-group">
            <label for="{$key}">{$titre}</label>
            <input type="{$type}" class="form-control {$this->getInputClass($key)}" name="{$key}" value="{$value}" required>
            {$this->getErrorFeedBack($key)}
        </div>
        HTML;
    }

    public function file(string $key, string $titre) : string
    {
        return<<<HTML
        <div class="form-group">
            <label for="{$key}">{$titre}</label>
            <input type="file" class="form-control {$this->getInputClass($key)}" name="{$key}">
            {$this->getErrorFeedBack($key)}
        </div>
        HTML;
    }

    public function textarea(string $key, string $titre, int $row) : string
    {
        $required = $key !== 'mapGoogle' ? 'required' : '';
        return<<<HTML
        <div class="form-group">
            <label for="{$key}">{$titre}</label>
            <textarea class="form-control {$this->getInputClass($key)}" name="{$key}" rows="{$row}" $required>{$this->getValue($key)}</textarea>
            {$this->getErrorFeedBack($key)}
        </div>
        HTML;
    }

    public function select(string $key, string $titre, array $options = []): string
    {
        $optionsHTML = [];
        $value = $this->getValue($key);
        foreach($options as $k => $v) {
            $selected = in_array($k, $value) ? 'selected' : '';
            $optionsHTML[] = "<option value=\"$k\" $selected>$v</option>";
        }
        $optionsHTML = implode('', $optionsHTML);
        return<<<HTML
        <div class="form-group">
            <label for="{$key}">{$titre}</label>
            <select class="form-control {$this->getInputClass($key)}" name="{$key}[]" required multiple>
                {$optionsHTML}
            </select>
            {$this->getErrorFeedBack($key)}
        </div>
        HTML;
    }

    private function getValue(string $key)
    {
        // Sur un tableau
        if(is_array($this->data)) {
            if($this->data[$key] instanceof \DateTimeInterface) {
                return $this->data[$key]->format('d F Y'); 
            }
            return $this->data[$key];
        }

        // Sur un objet 
        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        $value = $this->data->$method();
        if($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s'); 
        }
        return $value;
    }

    private function getInputClass($key) : string
    {
        return isset($this->errors[$key]) ? 'is-invalid' : '';
    }

    private function getErrorFeedBack(string $key) : string
    {
        if(isset($this->errors[$key])) {
            if(is_array($this->errors[$key])) {
                $error = implode('<br />', $this->errors[$key]);
            } else {
                $error = $this->errors[$key];
            }
            return '<div class="invalid-feedback">'. $error .'</div>';
        }
        return '';
    }
}

?>