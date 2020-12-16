<?php
/**
 * Code Golf: Help me compress this song
 *
 * @link https://codegolf.stackexchange.com/questions/216411/help-me-compress-this-song
 */

// The code-golf framework includes the testing frameworks and handles the command line
require __DIR__.'/a/CodeGolfFramework.php';


class HelpMeCompressThisSong extends ACodeGolfProblem
{
    // required methods
    public function runTests() {
        it(
            'generates the target poem',
            $this->getFunctionOutput(function () { $this->cmprssThsSng(); }) === self::EXPECTED_OUTPUT
        );
    }

    public function getTheGolfedCode() {
        return str_replace('\n', "\n", parent::getFunctionBody('cmprssThsSng', __CLASS__));
    }

    public function runTheGolfedCode($argc, array $argv) {
        this->cmprssThsSng();
    }

    public function cmprssThsSng() {
        $a='aeiou';$x='muha na zid';$y="Priletela $x,";echo implode("\n\n",array_merge([$z="$y $x, $x.\n$y\n$x."],array_map(fn($e)=>preg_replace("/[$a]/",$e,$z),str_split($a))));
    }

    const EXPECTED_OUTPUT = <<< END
Priletela muha na zid, muha na zid, muha na zid.
Priletela muha na zid,
muha na zid.

Pralatala maha na zad, maha na zad, maha na zad.
Pralatala maha na zad,
maha na zad.

Preletele mehe ne zed, mehe ne zed, mehe ne zed.
Preletele mehe ne zed,
mehe ne zed.

Prilitili mihi ni zid, mihi ni zid, mihi ni zid.
Prilitili mihi ni zid,
mihi ni zid.

Prolotolo moho no zod, moho no zod, moho no zod.
Prolotolo moho no zod,
moho no zod.

Prulutulu muhu nu zud, muhu nu zud, muhu nu zud.
Prulutulu muhu nu zud,
muhu nu zud.
END;
}

exit((new HelpMeCompressThisSong($argc, $argv))->run());


// That's all, folks!
