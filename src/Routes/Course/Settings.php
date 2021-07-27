<?php

namespace srag\Plugins\SoapAdditions\Routes\Course;

use ilSoapPluginException;
use srag\Plugins\SoapAdditions\Command\Course\Settings as SettingsCommand;
use srag\Plugins\SoapAdditions\Routes\Base;

/**
 * Class Settings
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Settings extends Base
{

    const P_COURSE_REF_ID = 'ref_id';
    const P_SHOW_TITLE_AND_ICON = 'show_title_and_icon';
    const P_SHOW_HEADER_ACTIONS = 'show_header_actions';
    const P_PASSED_DETERMINATION = 'passed_determination';
    const P_SORTING = 'sorting';
    const P_SORTING_DIRECTION = 'sorting_direction';
    const P_ACTIVATE_ADD_TO_FAVOURITES = 'activate_add_to_favourites';
    const P_POSITION_FOR_NEW_OBJECTS = 'position_for_new_objects';
    const P_ORDER_FOR_NEW_OBJECTS = 'order_for_new_objects';
    const P_SORTING_DIRECTION_FOR_NEW_OBJECTS = 'sorting_direction_for_new_objects';

    const P_LEARNING_PROGRESS_MODE = 'learning_progress_mode';
    const P_ACTIVATE_NEWS = 'activate_news';
    const P_ACTIVATE_TIMELINE = 'activate_news_timeline';
    const P_SHOW_NEW_AFTER = 'show_news_after_date';
    const P_SHOW_NEWS_TIMELINE_AUTO_ENTRIES = 'activate_news_timeline_auto_entries';
    const P_ACTIVATE_TIMELINE_LANDINGS_PAGE = 'activate_news_timeline_landing_page';

    /**
     * @param array $params
     * @return bool|mixed
     * @throws ilSoapPluginException
     */
    protected function run(array $params)
    {
        $command = new SettingsCommand((int) $params[self::P_COURSE_REF_ID]);
        $command->setShowTitleAndIcon($params[self::P_SHOW_TITLE_AND_ICON]);
        $command->setShowHeaderActions($params[self::P_SHOW_HEADER_ACTIONS]);
        $command->setPassedDetermination($params[self::P_PASSED_DETERMINATION]);
        $command->setSorting($params[self::P_SORTING]);
        $command->setSortingDirection($params[self::P_SORTING_DIRECTION]);
        $command->setPositionForNewObjects($params[self::P_POSITION_FOR_NEW_OBJECTS]);
        $command->setOrderForNewObjects($params[self::P_ORDER_FOR_NEW_OBJECTS]);
        $command->setActivateAddToFavourites($params[self::P_ACTIVATE_ADD_TO_FAVOURITES]);

        $command->setLearningProgressMode($params[self::P_LEARNING_PROGRESS_MODE]);
        $command->setActivateNews($params[self::P_ACTIVATE_NEWS]);
        $command->setActivateNewsTimeline($params[self::P_ACTIVATE_TIMELINE]);
        $command->setActivateNewsTimelineAutoEntries($params[self::P_SHOW_NEWS_TIMELINE_AUTO_ENTRIES]);
        $command->setActivateNewsTimelineLandingPage($params[self::P_ACTIVATE_TIMELINE_LANDINGS_PAGE]);

        $command->run();
        if ($command->wasSuccessful()) {
            return true;
        }
        $this->error($command->getUnsuccessfulReason());

        return true;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "updateCourseSettings";
    }

    /**
     * @return array
     */
    protected function getAdditionalInputParams() : array
    {
        return [
            $this->param_factory->int(self::P_COURSE_REF_ID),
            $this->param_factory->bool(self::P_SHOW_TITLE_AND_ICON),
            $this->param_factory->bool(self::P_SHOW_HEADER_ACTIONS),
            $this->param_factory->int(self::P_PASSED_DETERMINATION, [
                $this->param_factory->possibleValue(1, 'Through Learning Progress'),
                $this->param_factory->possibleValue(2, 'Only Manual by Tutors'),
            ]),
            $this->param_factory->int(self::P_SORTING, [
                $this->param_factory->possibleValue(0, 'Titles in Alphabetical Order'),
                $this->param_factory->possibleValue(4, 'By Creation Date'),
                $this->param_factory->possibleValue(2, 'Sort by Activation'),
                $this->param_factory->possibleValue(1, 'Manually'),
            ]),
            $this->param_factory->string(self::P_SORTING_DIRECTION, [
                $this->param_factory->possibleValue('asc', 'ASC'),
                $this->param_factory->possibleValue('desc', 'DESC'),
            ]),
            $this->param_factory->bool(self::P_ACTIVATE_ADD_TO_FAVOURITES),
            $this->param_factory->string(self::P_POSITION_FOR_NEW_OBJECTS, [
                $this->param_factory->possibleValue('top', 'Top'),
                $this->param_factory->possibleValue('bottom', 'Bottom'),
            ]),
            $this->param_factory->int(self::P_ORDER_FOR_NEW_OBJECTS, [
                $this->param_factory->possibleValue(0, 'Titles in Alphabetical Order'),
                $this->param_factory->possibleValue(1, 'By Creation Date'),
                $this->param_factory->possibleValue(2, 'Sort by Activation'),
            ]),
            $this->param_factory->int(self::P_LEARNING_PROGRESS_MODE, [
                $this->param_factory->possibleValue(0, 'Learning Progress is Deactivated'),
                $this->param_factory->possibleValue(11, 'Tutors Monitor and Set Status'),
                $this->param_factory->possibleValue(5, 'Status is Determined by a Collection of Items'),
            ]),
            $this->param_factory->bool(self::P_ACTIVATE_NEWS),
            $this->param_factory->bool(self::P_ACTIVATE_TIMELINE),
            $this->param_factory->string(self::P_POSITION_FOR_NEW_OBJECTS, []),
            $this->param_factory->bool(self::P_SHOW_NEWS_TIMELINE_AUTO_ENTRIES),
            $this->param_factory->bool(self::P_ACTIVATE_TIMELINE_LANDINGS_PAGE),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getOutputParams()
    {
        return ['success' => Base::TYPE_BOOL];
    }

    /**
     * @inheritdoc
     */
    public function getShortDocumentation()
    {
        return "Updates the settings of a course to the data given";
    }

    protected function getSampleRequest()
    {
        return "";
    }

}
