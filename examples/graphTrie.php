<?php

use Tries\TrieNode;

include('../classes/Bootstrap.php');

/**
 * Adds capability to dump a trie to DOT notation.
 * Class GraphTrie
 */
class GraphTrie extends \Tries\Trie {

    public function graph() {
        print "digraph trie {\n";

        // print root element
        print "  \"_\" [label=\"ROOT\"];\n";

        // Walk the trie
        $this->walk($this->trie);

        print "}\n";
    }

    protected function walk(TrieNode $trie, $prefix = "_") {
        if ($trie->valueNode !== null) {
            // We could print the end-node value here...
        }

        // Children is null, not an empty array by default
        if (is_array($trie->children)) {
            foreach ($trie->children as $key => $child) {
                // Create node
                print "  \"" . $prefix . $key . "\" [label=\"" . $key . "\"];\n";

                // Create connection between parent and child node
                print "  \"" . $prefix . "\" -> \"" . $prefix . $key . "\";\n";

                // Walk the child
                $this->walk($child, $prefix . $key);
            }
        }
    }
}





function buildTrie($fileName) {
    $playerData = json_decode(
        file_get_contents($fileName)
    );

    $trie = new GraphTrie();
    foreach($playerData as $player) {
        $playerName = $player->surname . ', ' . $player->firstname;
        $trie->add(strtolower($playerName), $player);
    }
    return $trie;
}


$trie = buildTrie(__DIR__ . '/../data/RugbyData.json');
$trie->graph();
exit;



