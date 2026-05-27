<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Perfil do usuario') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Atualize seus dados e a imagem redonda exibida na navegacao do sistema.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    if (! $refs.photo.files.length) return;
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Foto de perfil') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-3 flex items-center gap-4" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="size-20 rounded-full object-cover ring-4 ring-teal-50">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">{{ $this->user->name }}</p>
                    </div>
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-3 flex items-center gap-4" x-show="photoPreview" style="display: none;">
                    <span class="block size-20 rounded-full bg-cover bg-center bg-no-repeat ring-4 ring-teal-50"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Previa da nova foto</p>
                        <p class="text-sm text-slate-500">Salve para aplicar no perfil.</p>
                    </div>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Escolher nova foto') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remover foto') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nome') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Salvo.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Salvar') }}
        </x-button>
    </x-slot>
</x-form-section>
