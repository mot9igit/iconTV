<?php
if (!class_exists('iconTvInputRender')) {
    class iconTvInputRender extends modTemplateVarInputRender
    {
        public function getTemplate()
        {
            return $this->modx->getOption('core_path') . 'components/icontv/elements/tv/tpl/icontv.tpl';
        }

        public function process($value, array $params = array())
        {
            $corepath = MODX_BASE_PATH . '/core/components/icontv/';
            $config_path = $corepath . 'elements/config/';
            $config_file = $config_path . htmlspecialchars($params['icons']) . '.json';
            $icons = '{}';
            $link = '';
            if (file_exists($config_file) && (filesize($config_file) > 0)) {
                $config = json_decode(file_get_contents($config_file));
                $link = '<link rel="stylesheet" href="' . $config->fonts->css . '" ';
                $link .= !empty($config->fonts->integrity) ? 'integrity="' . $config->fonts->integrity . '"' : '';
                $link .= !empty($config->fonts->crossorigin) ? 'crossorigin="' . $config->fonts->crossorigin . '"' : '';
                $link .= '>';
                $icons = json_encode($config->keys,JSON_PRETTY_PRINT);
                $icontvjs = $this->modx->getOption('assets_url') . 'components/icontv/js/mgr/icontv.js';
                if (file_exists(MODX_BASE_PATH . $icontvjs))
                    $icontvjs = $icontvjs . '?v=' . filemtime(MODX_BASE_PATH . $icontvjs);
                $this->modx->regClientStartupScript($icontvjs);
            }
            //   $this->modx->regClientCSS($this->modx->getOption('assets_url').'components/icontv/css/mgr.css');

            $this->setPlaceholder('tv_value', $value);
            $this->setPlaceholder('icons', $icons);
            $this->setPlaceholder('font_css', $link);
        }
    }
}
return 'iconTvInputRender';