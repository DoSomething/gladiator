# Load DSL and Setup Up Stages
require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'

# Run Composer and NPM install tasks
require 'capistrano/composer'
require 'capistrano/npm'

# Loads custom tasks from `config/capistrano' if you have any defined.
Dir.glob('config/capistrano/*.rake').each { |r| import r }
