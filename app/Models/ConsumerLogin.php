<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConsumerLogin
 *
 * @property int $login_id
 * @property int $consumer_id
 * @property string|null $user_name
 * @property string|null $email
 * @property string $mobile_no
 * @property string $user_pass
 * @property string|null $token
 * @property Carbon $last_login
 *
 * @property ConsumerInformation $consumer_information
 *
 * @package App\Models
 */
class ConsumerLogin extends Model
{
	protected $table = 'consumer_login';
	protected $primaryKey = 'login_id';
	public $timestamps = false;


}
