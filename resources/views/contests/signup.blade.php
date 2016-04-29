@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Add user',
        'subtitle' => 'Add a user to a competition or watiting room'
    ])

    <div class="container">
        <div class="wrapper">
            <form method="POST" action="{{ route('contests.user.add', $contest->id) }}">
                <div class="form-item -padded">
                    <label class="field-label" for="id">User identification:</label>
                    <input type="text" name="id" id="id" class="text-field" placeholder="Email, Mobile Phone Number, Northstar ID or Phoenix ID"/>
                </div>

                <div class="form-item -padded">
                    <label class="field-label" for="term">Select user ID type:</label>
                    <div class="select">
                        <select name="term" id="term">
                            <option value="email" {{! isset($user->id) ? 'selected' : '' }}>Email</option>
                            <option value="mobile">Mobile Phone Number</option>
                            <option value="id" {{ isset($user->id) ? 'selected' : '' }}>Northstar ID</option>
                            <option value="drupal_id">Phoenix ID</option>
                        </select>
                    </div>
                </div>
                <div class="container__row">
                    <div class="container__block">
                        <h3>Make a choice, but make sure it's a good one.</h3>
                        <p>You can put someone in a waiting room or a competition, but not both.</p>
                    </div>
                    <div class="container__block -half">
                        <div class="form-item">
                            <label class="field-label" for="id">Waiting Room ID:</label>
                            <div class="select">
                                <select name="waitingroom_id" id="waitingroom_id">
                                    <option value="none">None</option>
                                    <option value="waitingroom">{{ $contest->waitingroom->id }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="container__block -half">
                        <div class="form-item">
                            <label class="field-label" for="id">Competition ID:</label>
                            <div class="select">
                                <select name="contest_id" id="contest_id">
                                    <option value="none">None</option>
                                    @foreach ($contest->competitions as $competition)
                                    <option value="competition-{{ $competition->id }}">{{ $competition->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="container__block">
                        <input type="submit" class="button" value="Submit" />
                    </div>
            </form>
        </div>
    </div>

@stop
