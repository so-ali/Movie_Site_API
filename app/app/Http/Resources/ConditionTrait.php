<?php

namespace App\Http\Resources;

use App\Http\Resources\Trait\ResourceDataCollection;
use Illuminate\Http\Resources\MergeValue;
use Illuminate\Http\Resources\MissingValue;

trait ConditionTrait
{
    public array $condition = [];

    /**
     * set additional in resource
     *
     * @param array $data
     *
     * @return $this
     */
    public function additional(array $data): static
    {
        if (self::isNotAssoc($data)) {
            $this->condition = $data;
        } else {
            return parent::additional($data);
        }

        return $this;
    }

    /**
     * set condition in resource
     *
     * @return $this
     */
    public function condition(): static
    {
        $conditions = func_get_args();

        foreach ($conditions as $condition) {
            if (is_array($condition) || is_object($condition)) {
                if (is_array($condition)) {
                    if (self::isNotAssoc($condition)) {
                        foreach ($condition as $item) {
                            if (!in_array($item, $this->condition)) {
                                $this->condition[] = $item;
                            }
                        }
                    }
                }
            } else {
                if (!in_array($condition, $this->condition)) {
                    $this->condition[] = $condition;
                }
            }
        }

        return $this;
    }

    /**
     * remake collection data in resource
     *
     * @param $resource
     *
     * @return ResourceDataCollection
     */
    public static function collection($resource): ResourceDataCollection
    {
        return new ResourceDataCollection($resource);
    }

    /**
     * check exist condition key
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasCondition(string $key): bool
    {
        return in_array($key, $this->condition);
    }

    /**
     * check exist condition key (AND CONDITION)
     *
     * @param array|string $keys
     * @param mixed $value
     *
     * @return MergeValue|MissingValue
     */
    public function whenCondition(array|string $keys, mixed $value): MergeValue|MissingValue
    {
        if (is_array($keys)) {
            $flag = true;

            foreach ($keys as $key) {
                if (!$this->hasCondition($key)) {
                    $flag = false;
                }
            }

            if ($flag) {
                return new MergeValue(value($value));
            }
        } else {
            if ($this->hasCondition($keys)) {
                return new MergeValue(value($value));
            }
        }

        return new MissingValue;
    }

    /**
     * check exist condition key (OR CONDITION)
     *
     * @param array|string $keys
     * @param mixed $value
     *
     * @return MergeValue|MissingValue
     */
    public function whenConditionOr(array|string $keys, mixed $value): MergeValue|MissingValue
    {
        if (is_array($keys)) {
            $flag = false;

            foreach ($keys as $key) {
                if ($this->hasCondition($key)) {
                    $flag = true;
                    break;
                }
            }

            if ($flag) {
                return new MergeValue(value($value));
            }
        } else {
            if ($this->hasCondition($keys)) {
                return new MergeValue(value($value));
            }
        }

        return new MissingValue;
    }

    /**
     * check not exist condition key (AND CONDITION)
     *
     * @param array|string $keys
     * @param mixed $value
     *
     * @return MergeValue|MissingValue
     */
    public function whenNotCondition(array|string $keys, mixed $value): MergeValue|MissingValue
    {
        if (is_array($keys)) {
            $flag = true;

            foreach ($keys as $key) {
                if ($this->hasCondition($key)) {
                    $flag = false;
                }
            }

            if ($flag) {
                return new MergeValue(value($value));
            }
        } else {
            if (!$this->hasCondition($keys)) {
                return new MergeValue(value($value));
            }
        }

        return new MissingValue;
    }

    /**
     * check not exist condition key (OR CONDITION)
     *
     * @param array|string $keys
     * @param mixed $value
     *
     * @return MergeValue|MissingValue
     */
    public function whenNotConditionOr(array|string $keys, mixed $value): MergeValue|MissingValue
    {
        if (is_array($keys)) {
            $flag = false;

            foreach ($keys as $key) {
                if (!$this->hasCondition($key)) {
                    $flag = true;
                    break;
                }
            }

            if (!$flag) {
                return new MergeValue(value($value));
            }
        } else {
            if (!$this->hasCondition($keys)) {
                return new MergeValue(value($value));
            }
        }

        return new MissingValue;
    }

    /**
     * check exist additional key
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasAdditional(string $key): bool
    {
        return array_key_exists($key, $this->additional);
    }

    /**
     * get additional key
     *
     * @param string $key
     *
     * @return bool
     */
    public function getAdditional(string $key): mixed
    {
        return (isset($this->additional[$key])) ? $this->additional[$key] : null;
    }

    /**
     * check is assoc array
     *
     * @param array $array
     *
     * @return bool
     */
    private static function isNotAssoc(array $array): bool
    {
        if (empty($array)) {
            return false;
        }

        return empty(array_diff(array_keys($array), range(0, count($array) - 1)));
    }
}
