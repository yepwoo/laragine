<?php

namespace Core\Base\Traits\Response;

trait SendResponse
{
    /**
     * send the response
     *
     * @param array $result
     * @param string $message
     * @param bool $is_success
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result = [], $message = 'Success.', $is_success = true, $status_code = 200)
    {
        $result_key = $is_success ? 'data' : 'errors';

        $response   = [
            'is_success'  => $is_success,
            'status_code' => $status_code,
            'message'     => $message,
            $result_key   => $result
        ];

        // for paginated data
        if (isset($result['data']) && isset($result['links']) && isset($result['meta'])) {
            $response['data']  = $result['data'];
            $response['links'] = $result['links'];
            $response['meta']  = $result['meta'];
        }

        return response()->json($response, $status_code);
    }

    /**
     * send the exception response
     *
     * @param \Exception $e
     * @param bool $report
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendExceptionResponse($e, $report = true)
    {
        if ($report) {
            report($e);
        }

        $message  = 'OOPS! there is a problem in our side! we got your problem and we will fix that very soon.';

        return $this->sendResponse([], $message, false, 500);
    }
}
