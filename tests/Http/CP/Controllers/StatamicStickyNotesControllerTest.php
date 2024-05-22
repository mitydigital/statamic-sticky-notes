<?php

use MityDigital\StatamicStickyNotes\Facades\StatamicStickyNotes;
use Statamic\Facades\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::make()
        ->makeSuper()
        ->set('name', 'Peter Parker')
        ->email('peter.parker@spiderman.com')
        ->set('password', 'secret')
        ->save();

    actingAs($this->user);
});

it('can show the sticky notes management view', function () {
    $this->get(route('statamic.cp.statamic-sticky-notes.show'))
        ->assertOk()
        ->assertViewIs('statamic-sticky-notes::show');
});

it('ensures show is a boolean', function () {
    // a string is not a boolean
    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'show' => 'string',
    ])->assertSessionHasErrors('show');

    // an array is not a boolean
    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'show' => [],
    ])->assertSessionHasErrors('show');

    // an integer is not a boolean
    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'show' => 2,
    ])->assertSessionHasErrors('show');

    // a float is not a boolean
    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'show' => 3.53,
    ])->assertSessionHasErrors('show');

    // pass
    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'show' => true,
    ])->assertSessionDoesntHaveErrors('show');

    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'show' => false,
    ])->assertSessionDoesntHaveErrors('show');
});

it('requires a heading that is a string', function () {
    // missing
    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'heading' => null,
    ])->assertSessionHasErrors('heading');

    // not a string
    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'heading' => [],
    ])->assertSessionHasErrors('heading');

    // pass
    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'heading' => 'This is a string',
    ])->assertSessionDoesntHaveErrors('heading');
});

it('does not require an intro string', function () {
    $this->post(route('statamic.cp.statamic-sticky-notes.update'))
        ->assertSessionDoesntHaveErrors('intro');
});

it('requires content', function () {
    // missing
    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'content' => null,
    ])->assertSessionHasErrors('content');

    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'content' => [],
    ])->assertSessionHasErrors('content');

    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'content' => [
            [
                'type' => 'paragraph',
            ],
        ],
    ])->assertSessionDoesntHaveErrors('content');
});

it('can update the sticky notes content', function () {
    // we expect "save" to be called once
    StatamicStickyNotes::shouldReceive('save')->once();
    StatamicStickyNotes::partialMock();

    $this->withoutExceptionHandling();
    $this->post(route('statamic.cp.statamic-sticky-notes.update'), [
        'show' => true,
        'heading' => 'My heading',
        'content' => [
            [
                'type' => 'paragraph',
            ],
        ],
    ])->assertSuccessful();
});

it('requires permission to show', function () {
    $standardUser = User::make()
        ->set('name', 'Standard User')
        ->email('standard@user.com')
        ->set('password', 'secret')
        ->save();

    actingAs($standardUser);

    // make role
    $role = \Statamic\Facades\Role::make()
        ->title('Test Role')
        ->handle('test-role')
        ->permissions(['access cp', 'edit sticky notes for statamic']);
    $role->save();

    $this->get(route('statamic.cp.statamic-sticky-notes.show'))
        ->assertRedirect();

    // assign role to user
    $standardUser->assignRole($role);
    $standardUser->save();

    $this->get(route('statamic.cp.statamic-sticky-notes.show'))
        ->assertSuccessful();
});

it('requires permission to update', function () {
    $standardUser = User::make()
        ->set('name', 'Standard User')
        ->email('standard@user.com')
        ->set('password', 'secret')
        ->save();

    actingAs($standardUser);

    // make role
    $role = \Statamic\Facades\Role::make()
        ->title('Test Role')
        ->handle('test-role')
        ->permissions(['access cp', 'edit sticky notes for statamic']);
    $role->save();

    // get data payload
    $data = [
        'show' => true,
        'heading' => 'My heading',
        'content' => [
            [
                'type' => 'paragraph',
            ],
        ],
    ];

    $this->post(route('statamic.cp.statamic-sticky-notes.show'), $data)
        ->assertRedirect();

    // assign role to user
    $standardUser->assignRole($role);
    $standardUser->save();

    $this->post(route('statamic.cp.statamic-sticky-notes.show'), $data)
        ->assertSuccessful();
});
