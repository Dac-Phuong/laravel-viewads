<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use MongoDB\Laravel\Eloquent\Model ;
	use DateTimeInterface;
	
	class WhileIp extends Model
	{
		use HasFactory;
		/**
		 * Prepare a date for array / JSON serialization.
		 *
		 * @param \DateTimeInterface $date
		 *
		 * @return string
		 */
		protected function serializeDate( DateTimeInterface $date ) {
			return $date->format( 'Y-m-d H:i:s' );
		}
	}