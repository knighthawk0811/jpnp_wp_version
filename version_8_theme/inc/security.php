<?php
/**
 * version_8 security related functions
 *
 * @package version_8
 */


/**
* limit access to content and display an error message
*
* TODO: combine with the cutomizer for post ids
*
* @link
* @version 8.3.1906
* @since 8.3.1906
*/
if ( ! function_exists( 'version_8_view_access' ) ) :
function version_8_view_access($level = 0)
{
	//define page IDs
	$access[0] = 258; // access denied
	$access[1] = 286; // access not yet granted
	$access[2] = 209; // access must be logged in
	$access[3] = 324; // access zero attempts remaining

	//if set to predefined value which corresponds to pages
	if( !isset($access[intval($level)]) )
	{
		//default is to deny access
		$level = 0;
	}

	//display the selected page contents
	$the_query = new WP_Query( 'page_id=' . $access[$level] );
	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		//the_content();
		get_template_part( 'template-parts/content', 'page' );
	endwhile;
	wp_reset_postdata();
}
endif;



/**
 * Translates a number to a short alphanumeric version
 *
 * Translated any number up to 9007199254740992 to a shorter version in letters
 * e.g.: 9007199254740989 --> PpQXn7COf
 *
 * this function is based on alphaID by
 * kevin[at]vanzonneveld[dot]net
 * @link http://kvz.io/blog/2009/06/10/create-short-ids-with-php-like-youtube-or-tinyurl/
 *
 * @author    Joseph Neathawk
 * @copyright 2017 Joseph Neathawk (http://neathawk.us)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @version   0.1.0
 *
 * @param mixed   $input    String or long input to translate
 * @param boolean $decode   Reverses translation when true (default is to convert a number to a shortened string)
 * @param mixed   $padding  Number or boolean padds the result up to a specified min length
 * @param string  $pass_key Supplying a password makes it harder to calculate the original ID
 *
 * @return mixed string or long
 *
 */
if ( ! function_exists( 'version_8_url_short' ) ) :
	function version_8_url_short($input, $decode = false, $padding = 8, $pass_key = null)
	{
		$output = '';
		//list of characters that may be included in the output
		$index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		//base unit
		$base = strlen($index);
		if($padding < 8)
		{
			$padding = 8;
		}

		//will reshuffle the $index using the $pass_key
		if($pass_key !== null)
		{
			/* classic version
			for ($n = 0; $n < strlen($index); $n++)
			{
				$i[] = substr($index, $n, 1);
			}//*/
			//split $index string into array of single characters
			$i = str_split($index,1);

			$pass_hash = hash('sha256',$pass_key);
			$pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

			//* classic version required to keep $i and $p the same length
			for ($n = 0; $n < strlen($index); $n++)
			{
				$p[] = substr($pass_hash, $n, 1);
			}//*/
			//split $pass_hash string into array of single characters
			//$p = str_split($pass_hash,1);

			//sort $p descending, and also sort $i in the corresponding order
			//(every sort change made in $p will be made in $i and $i will not be in desc order afterward)
			array_multisort($p, SORT_DESC, $i);
			//put the re-arranged $i back into the $index
			$index = implode($i);
		}

		if($decode)
		{
			//DECODE
			// Digital number  <<--  alphabet letter code
			$len = strlen($input) - 1;

			for ($t = $len; $t >= 0; $t--)
			{
				$bcp = bcpow($base, $len - $t);
				$output = $output + strpos($index, substr($input, $t, 1)) * $bcp;
			}

			if (is_numeric($padding))
			{
				$padding--;

				if ($padding > 0)
				{
					$output -= pow($base, $padding);
				}
			}
		}
		else
		{
			//ENCODE
			// Digital number  -->>  alphabet letter code
			if (is_numeric($padding))
			{
				$padding--;

				if ($padding > 0)
				{
					$input += pow($base, $padding);
				}
			}

			for ($t = ($input != 0 ? floor(log($input, $base)) : 0); $t >= 0; $t--)
			{
				$bcp = bcpow($base, $t);
				$a   = floor($input / $bcp) % $base;
				$output = $output . substr($index, $a, 1);
				$input  = $input - ($a * $bcp);
			}
		}

		  return $output;
	}
	endif;

