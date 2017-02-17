role :app, %w{dosomething@gladiator}

server 'gladiator', user: 'dosomething', roles: %w{app}, master: true
