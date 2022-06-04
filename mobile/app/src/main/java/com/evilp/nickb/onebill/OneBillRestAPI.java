package com.evilp.nickb.onebill;

import com.loopj.android.http.*;

/**
 * Created by nickb on 2017-07-24.
 */

public class OneBillRestAPI {

    private static final String BASE_URL = "http://onebill.ga/request";

    private static AsyncHttpClient client = new AsyncHttpClient();

    public static void get(String url, RequestParams params, AsyncHttpResponseHandler responseHandler) {
        client.get(getAbsoluteUrl(url), params, responseHandler);
    }

    public static void post(String url, RequestParams params, AsyncHttpResponseHandler responseHandler) {
        client.post(getAbsoluteUrl(url), params, responseHandler);
    }

    private static String getAbsoluteUrl(String relativeUrl) {
        return BASE_URL + relativeUrl;
    }

}
