<?php

class ConstructionStagesCreate
{
	public $id;
	public $name;
	public $startDate;
	public $endDate;
	public $duration;
	public $durationUnit;
	public $color;
	public $externalId;
	public $status;

	protected $oldAttributes;
	protected $validator = ValidatorCreate::class;
	protected $fillable = ['name', 'startDate', 'endDate', 'durationUnit', 'color', 'externalId', 'status']; 

	public function __construct($data, ?int $id = null)
	{
		$this->setId($id);

		$this->setOldAttributes();

		$this->setAttributes($data);

		$this->setOldAttributes();

		$this->setDefaultValues();

		$this->validate();
	}

	public function setId(?int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

	protected function setOldAttributes()
    {
		if ($this->getId() > 0) {
			$current = new ConstructionStages();
			$this->oldAttributes = (object) $current->getSingle($this->getId())[0];
		}
    }

	public function getOldAttributes()
	{
		return $this->oldAttributes;
	}

	protected function setAttributes($data)
	{
		if(is_object($data)) {
			
			foreach ($this->fillable as $attr) {
				if (isset($data->$attr)) {
					$this->$attr = $data->$attr;
				} elseif (isset($this->oldAttributes->$attr)) {
					$this->$attr = $this->oldAttributes->$attr;
				}
			}

		}
	}

	protected function setDefaultValues()
	{
		// status
		if (!isset($this->status)) {
			$this->status = 'NEW';
		}

		// durationUnit
		if (!isset($this->durationUnit)) {
			$this->durationUnit = 'DAYS';
		}
		
		// duration
		if (!empty($this->startDate) && !empty($this->endDate)) {
			$start = new DateTime($this->startDate);
			$end = new DateTime($this->endDate);
			
			$interval = $start->diff($end);
			switch (strtoupper($this->durationUnit)) {
				case 'HOURS':
					$duration = $interval->h + ($interval->days * 24);
					break;
				case 'WEEKS':
					$duration = ceil($interval->days / 7);
					break;
				case 'DAYS':
				default:
					$duration = $interval->days;
					break;
			}
	
			$this->duration = $duration;
		} else {
			$this->duration = null;
		}
	}

	protected function validate()
    {
        $validator = new $this->validator();
        $rules = $validator->rules();

        foreach ($rules as $field => $ruleList) {
            foreach ($ruleList as $rule) {
				$args = explode(':', $rule);
								
                $methodName = array_shift($args);
				
				foreach($args as $argIndex => $argItem) {
					if (property_exists($this, $argItem)) {
						if (isset($this->$argItem)) {
							$args[$argIndex] = $this->$argItem;
						} else {
							$args[$argIndex] = null;	
						}
					}
				}
				
                array_unshift($args, $field, isset($this->$field) ? $this->$field : null);
				
                call_user_func_array([$validator, $methodName], $args);
            }
        }
    }
}