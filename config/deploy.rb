# config/deploy.rb file
lock '3.4.0'

set :application, "gladiator"
set :repo_url, 'git@github.com:DoSomething/gladiator.git'

set :user, "dosomething"
set :group, "dosomething"
set :use_sudo, false

set :branch, "master"
if ENV['branch']
    set :branch, ENV['branch'] || 'master'
end


set :keep_releases, 1

set :npm_flags, ''
set :composer_install_flags, '--no-dev --optimize-autoloader'

set :linked_files, %w{.env}
set :linked_dirs, %w{images storage/logs storage/dumps storage/system}
