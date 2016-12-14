<div class="container">
    <div class="wrapper">
        <div class="container__block">
            <h2 class="heading -banner">No Reportback Activity</h2>

            <table class="table">
                <thead>
                    <tr class="table__header">
                        <th class="table__cell">Name</th>
                        <th class="table__cell">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pending as $user)
                        <tr class="table__row">
                            <td class="table__cell"><a href="{{ route('users.show', $user->northstar_id) }}" target="_blank">{{ $user->first_name or 'Anonymous' }} {{ $user->last_initial or '' }}</a></td>
                            <td class="table__cell">{{ $user->email or 'n/a' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
