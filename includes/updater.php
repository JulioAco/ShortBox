class MiPluginUpdater {
    private $plugin_slug = 'mi-plugin';
    private $github_url = 'https://api.github.com/repos/JulioAco/ShortBox/releases/latest';

    public function __construct() {
        add_filter('pre_set_site_transient_update_plugins', [$this, 'check_for_update']);
    }

    public function check_for_update($transient) {
        if (empty($transient->checked)) return $transient;

        $remote = wp_remote_get($this->github_url, ['timeout' => 10]);

        if (!is_wp_error($remote) && wp_remote_retrieve_response_code($remote) == 200) {
            $release = json_decode(wp_remote_retrieve_body($remote));

            if (isset($release->tag_name) && version_compare($release->tag_name, $transient->checked[$this->plugin_slug], '>')) {
                $transient->response[$this->plugin_slug] = (object) [
                    'new_version' => $release->tag_name,
                    'package' => $release->zipball_url,
                    'slug' => $this->plugin_slug,
                    'url' => 'https://github.com/JulioAco/ShortBox'
                ];
            }
        }

        return $transient;
    }
}

new MiPluginUpdater();