<?php

namespace App\Services;

class InputValidationService extends Service
{
    /**
     * InputValidationService constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Validate keywords to search
     * @param array $param
     * @return array
     */
    private function validateParamSearch(array $param): array
    {
        $value = $param['value'];

        if ($value !== false && is_string($value) && !empty($value)) {
            $param['operator'] = 'like';
            $param['value'] = "%$value%";
            return $param;
        }

        return [];
    }

    /**
     * Validate if book is original or not
     * @param array $param
     * @return array
     */
    private function validateParamOriginal(array $param): array
    {
        $value = $param['value'];

        if ($value !== false && is_numeric($value) && (0 === $value || 1 === $value)) {
            $param['operator'] = '=';
            return $param;
        }

        return [];
    }

    /**
     * Validate if subject identifier is valid
     * @param array $param
     * @return array
     */
    private function validateParamSubject(array $param): array
    {
        $value = $param['value'];

        if ($value !== false && is_numeric($value) && $value > 0) {
            $param['operator'] = '=';
            return $param;
        }

        return [];
    }

    /**
     * Validate search params
     * @param array $params
     * @return array
     */
    public function validate(array $params): array
    {
        $output = [];

        foreach ($params as $key => $param) {
            if (false !== $param['value']) {
                $methodName = 'validateParam' . ucfirst(strtolower($key));
                $output[] = method_exists($this, $methodName) ? $this->$methodName($param) : [];
            }
        }

        return $output;
    }
}
