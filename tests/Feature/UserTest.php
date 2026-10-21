<?php

use App\Models\User;

test('Create a user that will pass the validation', function () {
    //Arrange
    $data =[
        'name'=>'test',
        'email'=>'test@test.com',
        'password'=>'12345678',
        'role'=>'admin'
    ];

    //Act
    $user = User::create($data);
    //Assert
    expect($user->name)->toBe('test');
    expect($user->email)->toBe('test@test.com');
    expect($user->role)->toBe('admin');
});

test('Craete a user that will fail the validition ', function () {

    //Arrange
    $data =[
        'name'=>'',
        'email'=>'test@test.com',
        
    ];
    //Act
    try {
        $user = User::create($data);
        $failed = false;
    } catch (\Illuminate\Database\QueryException $e) {
        $failed = true;
    }
    //Assert
    expect($failed)->toBeTrue();
    expect(User::where('email','test@test.com')->exists())->toBeFalse();
});
