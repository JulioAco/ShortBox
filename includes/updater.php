class MiPluginUpdater {
    private $plugin_slug = 'ShortBox;
    private $github_user = 'gabywnk'; // Cambia esto por tu usuario de GitHub
    private $github_repo = 'ShortBox;
    private $github_api = 'https://api.github.com/repos/JulioAco/ShortBox/releases/latest';

    public function __construct() {
        add_filter('pre_set_site_transient_update_plugins', [$this, 'check_for_update']);
        add_filter('plugins_api', [$this, 'plugin_info'], 10, 3);
    }

    public function check_for_update($transient) {
        if (empty($transient->checked)) return $transient;

        $remote = wp_remote_get($this->github_api, ['timeout' => 10]);

        if (!is_wp_error($remote) && wp_remote_retrieve_response_code($remote) == 200) {
            $release = json_decode(wp_remote_retrieve_body($remote));

            if (isset($release->tag_name) && version_compare($release->tag_name, $transient->checked[$this->plugin_slug], '>')) {
                $transient->response[$this->plugin_slug] = (object) [
                    'new_version' => $release->tag_name,
                    'package' => $release->zipball_url,
                    'slug' => $this->plugin_slug,
                    'url' => 'https://github.com/' . $this->github_user . '/' . $this->github_repo
                ];
            }
        }

        return $transient;
    }

    public function plugin_info($false, $action, $args) {
        if ($action !== 'plugin_information' || $args->slug !== $this->plugin_slug) {
            return $false;
        }

        $remote = wp_remote_get($this->github_api, ['timeout' => 10]);

        if (!is_wp_error($remote) && wp_remote_retrieve_response_code($remote) == 200) {
            $release = json_decode(wp_remote_retrieve_body($remote));

            return (object) [
                'name' => 'ShortBox,
                'slug' => $this->plugin_slug,
                'version' => $release->tag_name,
                'author' => '<a href="https://github.com/' . $this->github_user . '">Gabywnk</a>',
                'homepage' => 'https://github.com/' . $this->github_user . '/' . $this->github_repo,
                'sections' => ['description' => 'Acortador de enlaces gratuito'],
                'download_link' => $release->zipball_url
            ];
        }

        return $false;
    }
}

new MiPluginUpdater();