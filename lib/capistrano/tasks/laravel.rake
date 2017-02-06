namespace :laravel do
  desc 'Run Gulp build'
  task :gulp do
    on roles(:all) do
      within "#{release_path}" do
        execute "gulp"
      end
    end
  end

  desc 'Run Artisan tasks'
  task :artisan_tasks do
    on roles(:all) do
      within "#{release_path}" do
        execute :php, "artisan migrate && php artisan cache:clear"
      end
    end
  end
end

namespace :deploy do
 after :updated, "laravel:gulp"
 after :updated, "laravel:artisan_tasks"
end