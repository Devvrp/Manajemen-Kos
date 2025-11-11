<?php

class Validator
{
    private $errors = [];
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function validate($data, $rules)
    {
        foreach ($rules as $field => $ruleSet) {
            $value = $data[$field] ?? null;
            $ruleItems = explode('|', $ruleSet);
            foreach ($ruleItems as $rule) {
                $params = [];
                if (strpos($rule, ':') !== false) {
                    list($rule, $paramStr) = explode(':', $rule, 2);
                    $params = explode(',', $paramStr);
                }
                $methodName = 'validate' . ucfirst($rule);
                if (method_exists($this, $methodName)) {
                    $this->$methodName($field, $value, $params);
                }
            }
        }
        return empty($this->errors);
    }
    public function getErrors()
    {
        return $this->errors;
    }
    private function addError($field, $message)
    {
        if (empty($this->errors[$field])) {
            $this->errors[$field] = $message;
        }
    }
    private function validateRequired($field, $value, $params)
    {
        if ($value === null || $value === '') {
            $this->addError($field, 'Field ini wajib diisi.');
        }
    }
    private function validateEmail($field, $value, $params)
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'Format email tidak valid.');
        }
    }
    private function validateMin($field, $value, $params)
    {
        $min = (int)$params[0];
        if ($value && strlen($value) < $min) {
            $this->addError($field, "Minimal harus $min karakter.");
        }
    }
    private function validateConfirmed($field, $value, $params)
    {
        $confirmField = $params[0];
        $confirmValue = $_POST[$confirmField] ?? null;
        if ($value !== $confirmValue) {
            $this->addError($field, 'Konfirmasi password tidak cocok.');
        }
    }
    private function validateUnique($field, $value, $params)
    {
        $table = $params[0];
        $column = $params[1];
        $stmt = $this->db->prepare("SELECT 1 FROM $table WHERE $column = ?");
        $stmt->execute([$value]);
        if ($stmt->fetch()) {
            $this->addError($field, 'Nilai ini sudah terdaftar.');
        }
    }
}