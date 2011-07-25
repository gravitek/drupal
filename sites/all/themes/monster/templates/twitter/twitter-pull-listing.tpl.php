<?php
// $Id: twitter-pull-listing.tpl.php,v 1.2.2.3 2011/01/11 02:49:27 inadarei Exp $

/**
 * @file
 * Theme template for a list of tweets.
 *
 * Available variables in the theme include:
 *
 * 1) An array of $tweets, where each tweet object has:
 *   $tweet->id
 *   $tweet->username
 *   $tweet->userphoto
 *   $tweet->text
 *   $tweet->timestamp
 *
 * 2) $twitkey string containing initial keyword.
 *
 * 3) $title
 *
 */
?>
<div class="tweets">

  <?php if (is_array($tweets)): ?>
    <?php $tweet_count = count($tweets); ?>
    
    <ul class="tweets-pulled-listing">
    <?php foreach ($tweets as $tweet_key => $tweet): ?>
      <li>

        <span class="tweet-text"><?php print twitter_pull_add_links($tweet->text); ?></span>
        <div class="tweet-time"><?php print l($tweet->time_ago, 'http://twitter.com/' . $tweet->username . '/status/' . $tweet->id);?></div>

        <?php if ($tweet_key < $tweet_count - 1): ?>
        <?php endif; ?>
        
      </li>
    <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>
