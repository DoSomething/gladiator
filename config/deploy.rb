# config/deploy.rb file
require 'bundler/capistrano'

set :application, "gladiator"
set :deploy_to, ENV["DEPLOY_PATH"]
role :app, ENV["SERVER_NAME"]
role :web, ENV["SERVER_NAME"]
server  ENV["SERVER_NAME"], :app, :web

gateway = ENV["GATEWAY"]
unless gateway.nil?
  set :gateway, ENV["GATEWAY"]
end

set :user, "ubuntu"
set :group, "ubuntu"
set :use_sudo, false

set :repository, "."
set :scm, :none
set :deploy_via, :copy
set :keep_releases, 1

ssh_options[:keys] = [ENV["CAP_PRIVATE_KEY"]]

default_run_options[:shell] = '/bin/bash'

namespace :deploy do
  folders = %w{logs dumps system}

  task :link_folders do
    run "ln -nfs #{shared_path}/.env #{release_path}/"
    folders.each do |folder|
      run "ln -nfs #{shared_path}/#{folder} #{release_path}/storage/#{folder}"
    end
  end

  task :artisan_migrate do
    run "cd #{release_path} && php artisan migrate --force"
  end

  task :artisan_custom_styles do
    run "cd #{release_path} && php artisan custom-styles"
  end

  task :artisan_cache_clear do
    run "cd #{release_path} && php artisan cache:clear"
  end

  task :restart_queue_worker, :on_error => :continue do
    run "ps -ef | grep 'queue:work' | awk '{print $2}' | xargs sudo kill -9"
  end

end

after "deploy:update", "deploy:cleanup"
after "deploy:symlink", "deploy:link_folders"
