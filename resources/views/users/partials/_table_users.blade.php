<div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -banner">{{ $role }}</h2>

                <table class="table">
                    <thead>
                        <tr class="table__header">
                            <th class="table__cell">User</th>
                            <th class="table__cell">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="table__row">
                                <td class="table__cell"><a href="{{ route('users.show', $user->id) }}">{{ $user->first_name or 'Anonymous' }} {{ $user->last_name or '' }}</a></td>
                                <td class="table__cell">{{ $user->email or ''}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
