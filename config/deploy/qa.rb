role :app, %w{dosomething@gladiator-qa}

server 'gladiator-qa', user: 'dosomething', roles: %w{app}, master: true

