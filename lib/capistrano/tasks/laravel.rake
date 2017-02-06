namespace :laravel do
  desc 'Run Artisan tasks'
  task :artisan_tasks do
    on roles(:all) do
      within "#{release_path}" do
        execute :php, "artisan migrate --force && php artisan cache:clear"
      end
    end
  end
end

namespace :deploy do
 after :updated, "laravel:npm_run_build"
 after :updated, "laravel:artisan_tasks"
end