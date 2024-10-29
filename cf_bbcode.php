<?PHP

/* 
  Plugin Name: BBCode Shortcut
  Plugin URI: http://www.cristianofino.net/post/bbcode-shortcut-plugin-per-wordpress.aspx
  Description: BBCode Shortcut allows you to define many token with one or more associated values. The tokens are replaced in the post with customized snippets of code where the variables (in the form {0}...{N}) are in turn replaced with the previous values. 
  Version: 1.1.0
  Author: Cristiano Fino
  Author URI: http://www.cristianofino.net/
*/

/* 
  Copyright 2009 Cristiano Fino (email: cristiano.fino@bbs.olografix.org)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/


/* Adding plugin if not already exists function */ 

if (function_exists('cf_bbcode')) 
{
	add_filter('the_content', 'cf_bbcode');

	/* Adding parameters */
	add_option('cf_bbcode_count','2','');
	
	/* BBCode example 1: 
	     [screenweek: key]  where "key" is the code of the film. 
	     Print film card identified by the code "key" taken from screenweek.it
	*/  
	add_option('cf_bbcode_code_1', 'screenweek', '');
	add_option('cf_bbcode_script_1', '<script src="http://www.screenweek.it/film/{0}/embed.js" type="text/javascript"></script><script type="text/javascript">swMovieEmbed();</script>', '');
	add_option('cf_bbcode_script_feed_1', '<a href="http://www.screenweek.it/film/{0}">Click here to view additional film info</a>', '');
	add_option('cf_bbcode_enable_1', '1', '');

	/* BBCode example 2: 
	     [youtube: key]  where "key" is the code of the video. 
	     Embed video identified by the code "key" taken from youtube
	*/	
	add_option('cf_bbcode_code_2', 'youtube', '');
	add_option('cf_bbcode_script_2', '<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/{0}" width="425" height="350" ><param name="movie" value="http://www.youtube.com/v/{0}"></param><param name="wmode" value="transparent"></param></object>', '');
	add_option('cf_bbcode_script_feed_2', '<a href="http://www.youtube.com/watch?v={0}">Click here to view a video</a>', '');
	add_option('cf_bbcode_enable_2', '1', '');
	
	/* Adding menu and parameters page */
	add_action('admin_menu', 'cf_bbcode_admin_menu');
	
	/* Loading text domain */
	load_plugin_textdomain('cf_bbcode', PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/languages', dirname(plugin_basename(__FILE__)).'/languages');
}


/* Adding parameters page */

function cf_bbcode_admin_menu()
{
	add_submenu_page('plugins.php', 'BBCode Shortcut Plugin Options', 'BBCode Shortcut', 5, basename(__FILE__),'cf_bbcode_options_page'); 
}


/* Options page */

function cf_bbcode_options_page() {

    $hidden_field_name = 'mt_submit_hidden';
	$cf_max_bbcode = get_option('cf_bbcode_count');
    
    if( $_POST[ $hidden_field_name ] == 'A' )
    {
      $cf_max_bbcode ++;
      
      add_option('cf_bbcode_code_'.$cf_max_bbcode, '', '');
      add_option('cf_bbcode_script_'.$cf_max_bbcode, '', '');
      add_option('cf_bbcode_script_feed_'.$cf_max_bbcode, '', '');      
      add_option('cf_bbcode_enable_'.$cf_max_bbcode, '1', '');
      
      update_option('cf_bbcode_count', $cf_max_bbcode);
?>
	<div id="message" class="updated fade"><p><strong><?php _e('New BBCode added.', 'cf_bbcode' ); ?></strong></p></div>

<?php		
    }
    
    if( $_POST[ $hidden_field_name ] == 'D' )
    {		
      delete_option('cf_bbcode_code_'.$cf_max_bbcode);
      delete_option('cf_bbcode_script_'.$cf_max_bbcode);
      delete_option('cf_bbcode_script_feed_'.$cf_max_bbcode);      
      delete_option('cf_bbcode_enable_'.$cf_max_bbcode);

      $cf_max_bbcode --;
      
      update_option('cf_bbcode_count', $cf_max_bbcode);
?>
	<div id="message" class="updated fade"><p><strong><?php _e('Last BBCode removed.', 'cf_bbcode' ); ?></strong></p></div>
	
<?php		
    }
    
    for ($i = 1; $i <= $cf_max_bbcode; $i++)
    {
        $opt_name_code[$i] = 'cf_bbcode_code_'.$i;
        $opt_name_script[$i] = 'cf_bbcode_script_'.$i;
        $opt_name_script_feed[$i] = 'cf_bbcode_script_feed_'.$i;
        $opt_name_enable[$i] = 'cf_bbcode_enable_'.$i;
      
        $data_field_name_code[$i] = 'cf_bbcode_code_'.$i;
        $data_field_name_script[$i] = 'cf_bbcode_script_'.$i;
        $data_field_name_script_feed[$i] = 'cf_bbcode_script_feed_'.$i;
        $data_field_name_enable[$i] = 'cf_bbcode_enable_'.$i;

        // Read in existing option value from database
        $opt_val_code[$i] = get_option($opt_name_code[$i]);
        $opt_val_script[$i] = get_option($opt_name_script[$i]);
        $opt_val_script_feed[$i] = get_option($opt_name_script_feed[$i]);
        $opt_val_enable[$i] = get_option($opt_name_enable[$i]);
    }

    if( $_POST[ $hidden_field_name ] == 'Y' ) {
      for ($i = 1; $i <= $cf_max_bbcode; $i++)
      {	
	        $opt_val_code[$i] = $_POST[$data_field_name_code[$i]];
	        $opt_val_script[$i] = $_POST[$data_field_name_script[$i]];
	        $opt_val_script_feed[$i] = $_POST[$data_field_name_script_feed[$i]];
	        $opt_val_enable[$i] = $_POST[$data_field_name_enable[$i]];
	        
	        update_option($opt_name_code[$i], trim($opt_val_code[$i]));
	        update_option($opt_name_script[$i], trim($opt_val_script[$i]));
	        update_option($opt_name_script_feed[$i], trim($opt_val_script_feed[$i]));
	        update_option($opt_name_enable[$i], trim($opt_val_enable[$i]));	     
      }
        
?>
	<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'cf_bbcode' ); ?></strong></p></div>

<?php
    }
    echo '<div class="wrap">';
    echo "<h2>" . __( 'BBCode Shortcut Plugin Options', 'cf_bbcode' ) . "</h2>";
    ?>

	<form name="form_BBCode_Options" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
	<table class="form-table">
<?php 
	for ($i = 1; $i <= $cf_max_bbcode; $i++)
	{
?>
	<tr valign="top">
		<th scope="row"><label for="<?php echo $data_field_name_code[$i]; ?>"><?php _e("BBCode ".$i, 'cf_bbcode' ); ?></label></th>
		<td><input type="text" name="<?php echo $data_field_name_code[$i]; ?>" value="<?php echo $opt_val_code[$i]; ?>" size="20">
<?php 
	if ($i == $cf_max_bbcode && $i != 1) 
	{
?>
	<input type="button" class="button-secondary" name="RemoveBBCode" value="<?php _e('Remove this', 'cf_bbcode' ) ?>" onclick="javascript:if(confirm('<?php _e("Are you sure ?", 'cf_bbcode' ); ?>')){<?php echo $hidden_field_name; ?>.value='D';document.form_BBCode_Options.submit();}">		
<?php } ?>
		<br />
		<?php _e('This is your BBCode token n.', 'cf_bbcode') ?><?php echo($i.'.') ?><br />
		<?php _e('Usage: put [', 'cf_bbcode') ?><b><?php echo($opt_val_code[$i]) ?></b><?php _e(':<em>value-1,...,value-N</em>] in your post', 'cf_bbcode' ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="<?php echo $data_field_name_script[$i]; ?>"><?php _e("Script ".$i, 'cf_bbcode' ); ?></label></th>
		<td>
			<textarea name="<?php echo $data_field_name_script[$i]; ?>" rows="5" class="code" style="width:99%"><?php echo stripslashes($opt_val_script[$i]); ?></textarea><br/>
		<?php _e('This script replace the BBCode n.','cf_bbcode' ); ?><?php echo($i.'.') ?><br /> 
		<?php _e('{0}...{N} will be replaced by <em>value-1,...,value-N</em> contents in BBCode', 'cf_bbcode' ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="<?php echo $data_field_name_script_feed[$i]; ?>"><?php _e("Alternate feed Script ".$i, 'cf_bbcode' ); ?></label></th>
		<td>
			<textarea name="<?php echo $data_field_name_script_feed[$i]; ?>" rows="5" class="code" style="width:99%"><?php echo stripslashes($opt_val_script_feed[$i]); ?></textarea><br/>
		<?php _e('This script replace the BBCode n.','cf_bbcode' ); ?><?php echo($i.'.') ?><?php _e(' only in the feed. If it\'s left blank, it will not be used', 'cf_bbcode') ?><br /> 
		<?php _e('{0}...{N} will be replaced by <em>value-1,...,value-N</em> contents in BBCode', 'cf_bbcode' ); ?>
		</td>
	</tr>

	<tr>
		<th scope="row"><label for="<?php echo $data_field_name_enable[$i]; ?>"><?php _e("Enabled ", 'cf_bbcode' ); ?></label></th>
		<td>
		<select name="<?php echo $data_field_name_enable[$i]; ?>">
			<option value="0" <?php if($opt_val_enable[$i] == "0") echo 'selected' ?> ><?php _e("No", 'cf_bbcode' ); ?></option> 
			<option value="1" <?php if($opt_val_enable[$i] == "1") echo 'selected' ?> ><?php _e("Yes", 'cf_bbcode' ); ?> </option>
		</select><br />
      <?php _e('If disabled, the BBcode is replaced by null', 'cf_bbcode' ); ?>
		<br /> <hr/>	
		</td>
	</tr>
<?php } ?>
	<tr valign="center">
		<td></td><td align="right"><input type="button" class="button-secondary" name="NewBBCode" value="<?php _e('Add new BBCode', 'cf_bbcode' ) ?>" onclick="javascript:<?php echo $hidden_field_name; ?>.value='A';document.form_BBCode_Options.submit();"></td>
	</tr>
	</table>
	<p><em><?php _e('WARNING: (1) the BBcodes are case sensitive (2) you can recursively remove only the last BBCode.', 'cf_bbcode' ); ?></em></p>
	<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update Options', 'cf_bbcode' ) ?>" />
	</p>
	</form>
	</div>

<?php
}

/* Core function of BBCode Shortcut filter */

function cf_bbcode($body = '')
{
	$cf_max_bbcode = get_option('cf_bbcode_count');
	
	for ($i = 1; $i <= $cf_max_bbcode; $i++)
	{
		$cf_bbcode_code = get_option('cf_bbcode_code_'.$i);
		$cf_bbcode_script = get_option('cf_bbcode_script_'.$i);
		$cf_bbcode_script_feed = get_option('cf_bbcode_script_feed_'.$i);
		$cf_bbcode_enable[$i] = get_option('cf_bbcode_enable_'.$i);

		if (cf_bbcode_code != '' && strpos($body,"[".$cf_bbcode_code.":"))
		{	
			if (preg_match_all("@\[".$cf_bbcode_code.":(.*?)\]@", $body, $Matches) > 0)
			{
				foreach ($Matches[1] as $pos => $Match)
				{
					$BBCodeArgs = trim($Match);	
					$BBCodeArg = explode(',',$BBCodeArgs);
										
					for ($j = 0; $j < count($BBCodeArg); $j++)
            $wildcard[$j] = '{'.$j.'}';
					
					$script = '';
					
					if ($cf_bbcode_enable[$i] == '1')
					{ 
						if (is_feed() && $cf_bbcode_script_feed != '')
                $cf_bbcode_script = $cf_bbcode_script_feed;
						
						$script = stripslashes(str_replace($wildcard, $BBCodeArg, $cf_bbcode_script));	
					}
					$body = str_replace($Matches[0][$pos], $script, $body); 
				}
			}
		}
	}
	return $body;	
}

?>
