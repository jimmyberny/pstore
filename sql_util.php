<?php 
#Funciones util para generar el sql

function getBindings( $fields, $bindings ) 
{
    $res = array();
    foreach ( $fields as $fn ) 
    {
        if ( array_key_exists( $fn, $bindings ) )
        {
            $res[] = $bindings[$fn];
        }
        else
        {
            $res[] = $fn;
        }
    }
    return $res;
}

function getSelect( $table, $whereFields = array() ) 
{
    $fs = implode( ', ', $table['fields'] );

    # Where
    $where = '';
    if ( count( $whereFields ) != 0 )
    {
        $where .= ' where ';
        for ( $i = 0, $size = count( $whereFields ),  $last = $size - 1; $i < $size; $i++ )
        {
            $wf = $whereFields[$i];
            if ( is_array( $wf ) )
            { # %field% %cmp% :%field% [and]
                $where .= $wf[0] . $wf[1] . ' :' . $wf[0];
                $where .= ( $i == $last ? '' : ' and ');
            }
            else
            { # %field% = :%field% [and]
                $where .= $wf . ' = :' . $wf . ( $i == $last ? '' : ' and ' );
            }
        }
    }

    # Order by
    if ( isset( $table['order'] ) ) 
    {
        $obs = array();
        foreach ( $table['order'] as $pos ) 
        {
            $obs[] = $table['fields'][$pos];
        }
        $ob = ' order by ' . implode( ", ", $obs );
    } 
    else 
    {
        $ob = ""; 
    }
    return "select " . $fs . " from " . $table['name'] . $where . ' ' . $ob;
}

function getSelectByIds( $table ) {
    $where = array();
    foreach ( $table['ids'] as $f ) 
    {
        $where[] = $table['fields'][$f];
    }

    return getSelect( $table, $where );
}

function getInsert( $table )
{
    $fs = implode( ', ', $table['fields'] );
    $qm = array();
    foreach ( $table['fields'] as $com ) 
    {
        if ( array_key_exists( $com, $table['form'] ) ) 
        {
            $com = $table['form'][$com];
        }
        $qm[] = ':' . $com;
    }
    $qm = implode( ',' , $qm );
    return 'insert into ' . $table['name'] . ' (' . $fs . ') values (' . $qm . ')';
}
?>