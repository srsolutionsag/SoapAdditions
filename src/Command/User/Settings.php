<?php namespace srag\Plugins\SoapAdditions\Command\User;

use srag\Plugins\SoapAdditions\Command\Command;
use srag\Plugins\SoapAdditions\Command\Base;
use srag\Plugins\SoapAdditions\Routes\User\Settings as SettingsCommand;

/**
 * Class Settings
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Settings extends Base implements Command
{
    protected $user_id = 0;
    protected $params = [];

    /**
     * Settings constructor.
     * @param int   $user_id
     * @param array $params
     */
    public function __construct(int $user_id, array $params)
    {
        $this->user_id = $user_id;
        $this->params = $params;
    }

    /**
     * @return \ilObjUser
     */
    protected function getUser() : \ilObjUser
    {
        if (!isset($this->user_object)) {
            $this->user_object = new \ilObjUser($this->user_id);
        }
        return $this->user_object;
    }

    public function run()
    {
        if (!$this->params[SettingsCommand::P_ACTIVATE_PUBLIC_PROFILE]) {
            $this->getUser()->setPref("public_profile", 'n');
            $this->getUser()->update();
            return;
        }

        $this->getUser()->setPref("public_profile", 'y');

        foreach ($this->params as $k => $param) {
            if ($k === SettingsCommand::SID || $k === SettingsCommand::P_ACTIVATE_PUBLIC_PROFILE) {
                continue;
            }
            $k = str_replace(SettingsCommand::PREFIX_SHOW, "", $k);
            $this->getUser()->setPref("public_" . $k, $param ? "y" : "n");
        }
        $this->getUser()->update();
    }

}
