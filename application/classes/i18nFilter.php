<?php defined('SYSPATH') or die('No direct script access.');

class i18nFilter {
    public function get($value, $helper) {
		I18n.lang('ru');
        return I18n::get($value);
    }
}