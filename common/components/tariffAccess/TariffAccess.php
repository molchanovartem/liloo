<?php
namespace common\components\tariffAccess;

use yii\base\Component;

/**
 * Class TariffAccess
 *
 * @package common\components\tariffAccess
 */
class TariffAccess extends Component
{
    /**
     * @var array
     */
    private $rules = [];
    /**
     * @var array
     */
    private $rulesClass = [];
    /**
     * @var array
     */
    private $tariffs = [];

    public function init()
    {
        parent::init();

        $this->loadRulesClass();
    }

    private function loadRulesClass()
    {
       foreach (scandir(__DIR__  . DIRECTORY_SEPARATOR . 'rules') as $fileName) {
            if (substr($fileName, -8, 8) == 'Rule.php') {
                $className = __NAMESPACE__ . '\\rules\\' . pathinfo($fileName, PATHINFO_FILENAME);

                if (method_exists($className, 'getName')) $this->rulesClass[$className::getName()] = $className;
            }
        }
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \yii\base\UnknownPropertyException
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->rulesClass)) {
            $ruleClass = $this->rulesClass[$name];

            return $this->rules[$name] ?? ($this->rules[$name] = new $ruleClass($this));
        }
        parent::__get($name);
    }

    /**
     * @return array
     */
    public function getTariffs()
    {
        return $this->tariffs;
    }
}