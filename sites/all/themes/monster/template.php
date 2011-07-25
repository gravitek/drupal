<?php

/**
 * Override or insert vars into the html template.
 */
function monster_preprocess_html(&$vars) {
  //Add conditional CSS for IE8 and below.
  drupal_add_css(path_to_theme() . '/css/ie7.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lt IE 8', '!IE' => FALSE), 'preprocess' => FALSE));
  // Add conditional CSS for IE6.
  drupal_add_css(path_to_theme() . '/css/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lt IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
  
  //krumo($vars);
  
  if(strpos($vars['head_title'], 's blog')) {
    $vars['classes_array'][] = ' author-blog'; 
  }
}

/**
 * Override or insert vars into the page template.
 */
function monster_preprocess_page(&$vars) {
  if(arg(0) == 'blog' && !arg(1)) {
    drupal_set_title('Blog');
  }
  
  if(arg(0) == 'search' && arg(2)) {
    drupal_set_title('Search Results');
  }
}

function monster_preprocess_node(&$vars) {
  $vars['node'] = $vars['elements']['#node'];
  $node = $vars['node'];

  $vars['date'] = format_date($node->created,'short');
  $vars['name'] = theme('username', array('account' => $node));
  
  //krumo($vars['content']['links']);
  unset($vars['content']['links']['blog']);
	unset($vars['content']['links']['comment']['#links']['comment-new-comments']);
	unset($vars['content']['links']['comment']['#links']['comment-comments']);
	unset($vars['content']['links']['comment']['#links']['comment-add']);
  unset($vars['content']['links']['comment']['#links']['comment_forbidden']);

  if($node->type == 'blog' && $vars['page']) {
    $author = user_load($node->uid);
    //krumo($author);
    $vars['author_title'] = check_plain($author->field_user_title['und'][0]['safe_value']);
    $vars['author_blog'] = t('Read more from ') . l(t('this author'), 'blog/'. $node->uid);
  }
}

function monster_preprocess_search_result(&$vars) {
  if ($vars['result']['node']->type == 'blog') {
    $vars['type'] = t('Blog entry');
  } else {
    $vars['type'] = $vars['result']['node']->type;
  }
  
  $vars['date'] = $vars['info_split']['date'];
  $vars['comment'] = $vars['info_split']['comment'];
}

function monster_preprocess_user_profile(&$vars) {
  $account = $vars['elements']['#account'];
  
  //krumo($account);
  
  $vars['user_name'] = $account->name;
  
  if (user_access('create blog content', $account)) {
    $vars['blog_link'] = t('Read more from ') . l(t('this author'), 'blog/'. $account->uid);
  }
 
}