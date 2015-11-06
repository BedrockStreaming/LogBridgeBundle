<?php

/**
 * TestLogMatcher
 *
 * This class has been auto-generated
 * by the M6Web LogBridgeBundle.
 */
class TestLogMatcher implements M6Web\Bundle\LogBridgeBundle\Matcher\MatcherInterface
{
    /**
     * @var array
     * List of compiled filters
     */
    private $filters = [
        'get_clip.GET.all' => [
            'options' => [
                'response_body' => true,
                'post_parameters' => true,
            ],
            'level' => 'info',
        ],
        'get_clip.PUT.all' => [
            'options' => [
                'response_body' => true,
                'post_parameters' => true,
            ],
            'level' => 'info',
        ],
        'put_clips_form.PUT.200' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.201' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.202' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.203' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.204' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.205' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.206' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.207' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.208' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.209' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.210' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.211' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.212' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.213' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.214' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.215' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.216' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.217' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.218' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.219' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.220' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.221' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.222' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.223' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.224' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.225' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.226' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.227' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.228' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.229' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.230' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.231' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.232' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.233' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.234' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.235' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.236' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.237' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.238' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.239' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.240' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.241' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.242' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.243' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.244' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.245' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.246' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.247' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.248' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.249' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.250' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.251' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.252' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.253' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.254' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.255' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.256' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.257' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.258' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.259' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.260' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.261' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.262' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.263' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.264' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.265' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.266' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.267' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.268' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.269' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.270' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.271' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.272' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.273' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.274' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.275' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.276' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.277' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.278' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.279' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.280' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.281' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.282' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.283' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.284' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.285' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.286' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.287' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.288' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.289' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.290' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.291' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.292' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.293' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.294' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.295' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.296' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.297' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.298' => [
            'options' => [],
            'level' => 'info',
        ],
        'put_clips_form.PUT.299' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.500' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.501' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.502' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.503' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.504' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.505' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.506' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.507' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.508' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.509' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.510' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.511' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.512' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.513' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.514' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.515' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.516' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.517' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.518' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.519' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.520' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.521' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.522' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.523' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.524' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.525' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.526' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.527' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.528' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.529' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.530' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.531' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.532' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.533' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.534' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.535' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.536' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.537' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.538' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.539' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.540' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.541' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.542' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.543' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.544' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.545' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.546' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.547' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.548' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.549' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.550' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.551' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.552' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.553' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.554' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.555' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.556' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.557' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.558' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.559' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.560' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.561' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.562' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.563' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.564' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.565' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.566' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.567' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.568' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.569' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.570' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.571' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.572' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.573' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.574' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.575' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.576' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.577' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.578' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.579' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.590' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.591' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.592' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.593' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.594' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.595' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.596' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.597' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.598' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.599' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.500' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.501' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.502' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.503' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.504' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.505' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.506' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.507' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.508' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.509' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.510' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.511' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.512' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.513' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.514' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.515' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.516' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.517' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.518' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.519' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.520' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.521' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.522' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.523' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.524' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.525' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.526' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.527' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.528' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.529' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.530' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.531' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.532' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.533' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.534' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.535' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.536' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.537' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.538' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.539' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.540' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.541' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.542' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.543' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.544' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.545' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.546' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.547' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.548' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.551' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.552' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.553' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.554' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.555' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.556' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.557' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.558' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.559' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.560' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.561' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.562' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.563' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.564' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.565' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.566' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.567' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.568' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.569' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.570' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.571' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.572' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.573' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.574' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.575' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.576' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.577' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.578' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.579' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.580' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.581' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.582' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.583' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.584' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.585' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.586' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.587' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.588' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.589' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.590' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.591' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.592' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.593' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.594' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.595' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.596' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.597' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.598' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.599' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.300' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.301' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.302' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.303' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.304' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.305' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.306' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.307' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.308' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.PATH.309' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.POST.404' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.POST.405' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.POST.406' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.POST.407' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.POST.408' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.POST.409' => [
            'options' => [],
            'level' => 'info',
        ],
        'edit_clip.POST.410' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.450' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.451' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.459' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.460' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.461' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.462' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.463' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.464' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.465' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.466' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.467' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.468' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.469' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.470' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.471' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.472' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.473' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.474' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.475' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.476' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.477' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.478' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.479' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.480' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.481' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.482' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.483' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.484' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.485' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.486' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.487' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.488' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.489' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.490' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.491' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.492' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.493' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.494' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.495' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.496' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.497' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.498' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.499' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.200' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.201' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.202' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.203' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.204' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.205' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.206' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.207' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.208' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.209' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.210' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.211' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.212' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.213' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.214' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.215' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.216' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.217' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.218' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.219' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.220' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.221' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.222' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.223' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.224' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.225' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.226' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.227' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.228' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.229' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.230' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.231' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.232' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.233' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.234' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.235' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.236' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.237' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.238' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.239' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.240' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.241' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.242' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.243' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.244' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.245' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.246' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.247' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.248' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.249' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.250' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.251' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.252' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.253' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.254' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.255' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.256' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.257' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.258' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.259' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.260' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.261' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.262' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.263' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.264' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.265' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.266' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.267' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.268' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.269' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.270' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.271' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.272' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.273' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.274' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.275' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.276' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.277' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.278' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.279' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.280' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.281' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.282' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.283' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.284' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.285' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.286' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.287' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.288' => [
            'options' => [],
            'level' => 'info',
        ],
        'get_program.GET.289' => [
            'options' => [],
            'level' => 'info',
        ]
    ];

    /**
     * getPositiveMatcher
     *
     * @param string  $route       Route name
     * @param string  $method      Method name
     * @param integer $status      Http code status
     *
     * @return array
     */
    private function getPositiveMatcher($route, $method, $status)
    {
        return [
            [$route, $method, $status],
            [$route, $method, 'all'],
            [$route, 'all', $status],
            ['all', $method, $status],
            [$route, 'all', 'all'],
            ['all', 'all', $status],
            ['all', $method, 'all'],
            ['all', 'all', 'all']
        ];
    }

    /**
     * match
     *
     * @param string  $route       Route name
     * @param string  $method      Method name
     * @param integer $status      Http code status
     *
     * @return boolean
     */   
    public function match($route, $method, $status)
    {
        if ($filterKey = $this->getMatchFilterKey($route, $method, $status)) {
            return true;
        }

        return false;
    }

    /**
     * generate filter key
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return string
     */
    public function generateFilterKey($route, $method, $status)
    {
        return sprintf('%s.%s.%s', $route, $method, $status);
    }

    /**
     * Get filter options
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return array
     */
    public function getOptions($route, $method, $status)
    {
        if ($filterKey = $this->getMatchFilterKey($route, $method, $status)) {
            return $this->filters[$filterKey]['options'];
        }

        return [];
    }

    /**
     * Get filter level log
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return string
     */
    public function getLevel($route, $method, $status)
    {
        if ($filterKey = $this->getMatchFilterKey($route, $method, $status)) {
            return $this->filters[$filterKey]['level'];
        }

        return 'info';
    }

    /**
     * addFilter
     *
     * @param string $filterKey Filter key
     * @param string $level     Filter Log level
     * @param array  $options   Filter options
     *
     * @return MatcherInterface
     */
    public function addFilter($filterKey, $level = 'info', array $options = [])
    {
        if (!$this->hasFilter($filterKey)) {
            $this->filters[$filterKey]            = [];
            $this->filters[$filterKey]['options'] = $options;
            $this->filters[$filterKey]['level']   = $level;
        }

        return $this;
    }

    /**
     * setFilters
     *
     * @param array   $filters   Filter list
     * @param boolean $overwrite Overwrite current filter
     *
     * @return MatcherInterface
     */
    public function setFilters(array $filters, $overwrite = false)
    {
        if ($overwrite) {
            $this->filters = $filters;
        } else {
            foreach ($filters as $filterKey => $filter) {

                if (!isset($filter['level'])) {
                    $filter['level'] = 'info';
                }

                if (!isset($filter['options'])) {
                    $filter['options'] = [];
                }

                $this->addFilter($filterKey, $filter['level'], $filter['options']);
            }
        }

        return $this;
    }

    /**
     * getFilters
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * hasFilter
     *
     * @param string $filterKey Filter key
     *
     * @return boolean
     */
    public function hasFilter($filterKey)
    {
        return array_key_exists($filterKey, $this->filters);
    }

    /**
     * get an filter key matched with arguments
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return bool|string
     */
    public function getMatchFilterKey($route, $method, $status)
    {
        if (!empty($this->filters)) {
            foreach ($this->getPositiveMatcher($route, $method, $status) as $rms) {
                $filterKey = $this->generateFilterKey($rms[0], $rms[1], $rms[2]);
                if ($this->hasFilter($filterKey)) {
                    return $filterKey;
                }
            }
        }

        return false;
    }
}
