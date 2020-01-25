<?php

namespace Quickweb\Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Support\Str;

class RepoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_add_record_with_bad_key_if_it_is_PascalCase_or_studly_capital_so_long_as_we_use_our_new_STR_macro()
    {
        // $this->withoutExceptionHandling();


        $array = [];
        $request = [

            'Password' => 123456,
            'Email'   => 'me@example.com',
            'Name'   => 'Jane Doe',
        ];



        $fields =  DB::getSchemaBuilder()
            ->getColumnListing('users');

        foreach ($request as $k => $v) {
            if (!in_array($k, $fields)) {
                if (in_array(Str::fromCamelCase($k), $fields)) {
                    $array[Str::fromCamelCase($k)] = $v;
                }
            } else {

                $array[$k] = $v;
            }
        }

        $user = new User(

            $array

        );
        $user->save();

        // dd(User::all());

        $this->assertNotEmpty(User::all());
    }
}
