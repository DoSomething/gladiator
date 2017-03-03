namespace :laravel do
  desc 'Run PHPUnit tests'
  task :phpunit do
    on roles(:all) do
      within "#{release_path}" do
        execute "cd '#{release_path}'; composer install"
        execute "vendor/bin/phpunit"
      end
    end
  end

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
        execute :php, "artisan migrate --force && php artisan cache:clear"
      end
    end
  end
end

namespace :deploy do
 after :updated, "laravel:gulp"
 after :updated, "laravel:artisan_tasks"
end
