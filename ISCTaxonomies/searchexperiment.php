
<?php
/*
[Mojamba, 2015] found the answer from onetrickpony to be great 
but it treats any search as a single term 
and also won't deal with a search phrase enclosed with quotation marks. 
[Mojamba, 2015] modified his code 
(specifically, the atom_search_where function) a
 bit to deal with these two situations. Here is my modified version of his code:
 */

// search all taxonomies, based on: http://projects.jesseheap.com/all-projects/wordpress-plugin-tag-search-in-wordpress-23

function atom_search_where($where){ 
    global $wpdb, $wp_query;
    if (is_search()) {
        $search_terms = get_query_var( 'search_terms' );

        $where .= " OR (";
        $i = 0;
        foreach ($search_terms as $search_term) {
            $i++;
            if ($i>1) $where .= " AND";     // --- make this OR if you prefer not requiring all search terms to match taxonomies
            $where .= " (t.name LIKE '%".$search_term."%')";
        }

        $where .= " AND {$wpdb->posts}.post_status = 'publish')";
    }
  return $where;
}

function atom_search_join($join){
  global $wpdb;
  if (is_search())
    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
  return $join;
}

function atom_search_groupby($groupby){
  global $wpdb;

  // we need to group on post ID
  $groupby_id = "{$wpdb->posts}.ID";
  if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

  // groupby was empty, use ours
  if(!strlen(trim($groupby))) return $groupby_id;

  // wasn't empty, append ours
  return $groupby.", ".$groupby_id;
}

add_filter('posts_where','atom_search_where');
add_filter('posts_join', 'atom_search_join');
add_filter('posts_groupby', 'atom_search_groupby');
?>