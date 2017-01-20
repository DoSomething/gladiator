<div class="container">
    <div class="wrapper">
        <div class="container__block">
            <h2 class="heading -banner">Flagged Reportbacks</h2>

            <table class="table">
                <thead>
                    <tr class="table__header">
                        <th class="table__cell">Name</th>
                        <th class="table__cell">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($flagged as $user)
                        <tr class="table__row">
                            <td class="table__cell"><a href="{{ route('users.show', $user->id) }}" target="_blank">{{ $user->first_name or 'Anonymous' }} {{ $user->last_initial or '' }}</a></td>
                            <td class="table__cell">{{ $user->reportback->quantity or 'n/a' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
