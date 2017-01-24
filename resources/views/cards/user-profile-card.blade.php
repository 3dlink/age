<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">

		<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
			<h2 class="mdl-card__title-text">{{$user->first_name.' '.$user->last_name}}'s profile</h2>
		</div>

		<div class="mdl-card card-wide" style="width:100%;" itemscope itemtype="http://schema.org/Person">
			<div class="mdl-user-avatar">
				@if($user->profile->profile_pic != NULL)
				<img src="{{ url($user->profile->profile_pic) }}" alt="{{ $user->name }}">
				@else
				<img src="{{ Gravatar::get($user->email) }}" alt="{{ $user->name }}">
				@endif
				<span itemprop="image" style="display:none;">{{ Gravatar::get($user->email) }}</span>
			</div>
			<div class="mdl-card__title" @if ($user->profile->user_profile_bg != NULL) style="background: url('{{$user->profile->user_profile_bg}}') center/cover;" @endif>
				<h3 class="mdl-card__title-text mdl-title-username">
					{{ $user->name }}
				</h3>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid full-grid padding-0">
					<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--6-col-desktop">
						<ul class="demo-list-icon mdl-list">
							<li class="mdl-list__item mdl-typography--font-light">
								<div class="mdl-list__item-primary-content">
									<i class="material-icons mdl-list__item-icon">person</i>
									<span itemprop="name">
										{{ $user->first_name }} @if ($user->last_name) {{ $user->last_name }} @endif
									</span>
								</div>
							</li>
							<li class="mdl-list__item mdl-typography--font-light">
								<div class="mdl-list__item-primary-content">
									<i class="material-icons mdl-list__item-icon">contact_mail</i>
									<span itemprop="email">
										{{ $user->email }}
									</span>
								</div>
							</li>
							@if ($user->profile)
							@if ($user->profile->phone)
							<li class="mdl-list__item mdl-typography--font-light">
								<div class="mdl-list__item-primary-content">
									<i class="material-icons mdl-list__item-icon">contact_phone</i>
									<span itemprop="email">
										{{ $user->profile->phone }}
									</span>
								</div>
							</li>
							@endif
							@if ($user->profile->skype_user)
							<li class="mdl-list__item mdl-typography--font-light">
								<div class="mdl-list__item-primary-content">
									<svg class="material-icons mdl-list__item-icon" style="width:24px;height:24px" viewBox="0 0 24 24">
										<path fill="#757575" d="M18,6C20.07,8.04 20.85,10.89 20.36,13.55C20.77,14.27 21,15.11 21,16A5,5 0 0,1 16,21C15.11,21 14.27,20.77 13.55,20.36C10.89,20.85 8.04,20.07 6,18C3.93,15.96 3.15,13.11 3.64,10.45C3.23,9.73 3,8.89 3,8A5,5 0 0,1 8,3C8.89,3 9.73,3.23 10.45,3.64C13.11,3.15 15.96,3.93 18,6M12.04,17.16C14.91,17.16 16.34,15.78 16.34,13.92C16.34,12.73 15.78,11.46 13.61,10.97L11.62,10.53C10.86,10.36 10,10.13 10,9.42C10,8.7 10.6,8.2 11.7,8.2C13.93,8.2 13.72,9.73 14.83,9.73C15.41,9.73 15.91,9.39 15.91,8.8C15.91,7.43 13.72,6.4 11.86,6.4C9.85,6.4 7.7,7.26 7.7,9.54C7.7,10.64 8.09,11.81 10.25,12.35L12.94,13.03C13.75,13.23 13.95,13.68 13.95,14.1C13.95,14.78 13.27,15.45 12.04,15.45C9.63,15.45 9.96,13.6 8.67,13.6C8.09,13.6 7.67,14 7.67,14.57C7.67,15.68 9,17.16 12.04,17.16Z" />
									</svg>
									<!-- {!! HTML::link('skype:'.$user->profile->skype_user.'?chat', $user->profile->skype_user, array('class' => 'skype-link mdl-typography--font-light', 'target' => '_blank')) !!} -->
									<span itemprop="skype">
										{{ $user->profile->skype_user }}
									</span>
								</div>
							</li>
							@endif
							@if ($user->profile->bio)
							<li class="mdl-list__item">
								<span class="mdl-list__item-primary-content">
									<i class="material-icons mdl-list__item-icon">comment</i>
									<p class="mdl-typography--font-light">
										{{ $user->profile->bio }}
										<meta itemprop="description" content="{{ $user->profile->bio }}">
									</p>
								</span>
							</li>
							@endif
							@endif
						</ul>
					</div>
					@if ($user->profile)
<!-- 						@if ($user->profile->location)
							<div class="mdl-cell mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--6-col-desktop margin-top-0 margin-top-2-desktop">
								<div class="card-image mdl-card mdl-shadow--2dp">
									<div id="map-canvas"></div>
									<div class="mdl-card__actions mdl-color--primary mdl-color-text--white">
										<p class="mdl-typography--font-light">
											LON: <span id="longitude"></span> / LAT: <span id="latitude"></span>
										</p>
									</div>
								</div>
							</div>
							@endif -->
							@endif
						</div>
					</div>
					<div class="mdl-card__actions">
						<div class="mdl-grid full-grid">
							<div class="mdl-cell mdl-cell--12-col">
								@if ($user->profile)
								@if (Auth::user()->id == $user->id)
								<a href="{{ route('profile.edit', Auth::user()->name) }}" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-shadow--3dp mdl-button--raised mdl-button--primary mdl-color-text--white">
									<i class="material-icons padding-right-half-1">edit</i>
									{{ Lang::get('titles.editProfile') }}
								</a>
								@endif
								@else
								<p class="text-center">{{ Lang::get('profile.noProfileYet') }}</p>
								{!! HTML::link(URL::to('/profile/'.Auth::user()->name.'/edit'), Lang::get('titles.createProfile'), array('class' => 'mdl-button mdl-js-button mdl-js-ripple-effect mdl-shadow--3dp')) !!}
								@endif
							</div>
						</div>
					</div>
					<div class="mdl-card__menu">

						@if (!Auth::guest() && Auth::user()->hasRole('super administrador'))
						<a href="{{ URL::to('users/' . $user->id . '/edit') }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
							<i class="material-icons">edit</i>
						</a>
						@endif

						<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
							<i class="material-icons">share</i>
						</button>
					</div>
				</div>
			</div>
		</div>