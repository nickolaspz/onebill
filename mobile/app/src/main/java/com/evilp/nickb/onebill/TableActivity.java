package com.evilp.nickb.onebill;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import cz.msebera.android.httpclient.Header;

public class TableActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_table);

        RequestParams params = new RequestParams();
        params.put("location", "iq74jayT");
        params.put("id", "1");

        OneBillRestAPI.get("/table", params, new JsonHttpResponseHandler() {
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                // If the response is JSONObject instead of expected JSONArray
                System.out.println("JSONObject: " + response.toString());
            }
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONArray response) {
                // Do something with the response
                System.out.println(response);

                List<Ticket> table = new ArrayList<Ticket>();

                try {
                    int i = 0;
                    while (response.getJSONObject(i) != null) {
                        Ticket ticket = new Ticket();

                        HashMap<String, String> map = new HashMap<String, String>();

                        JSONObject json = response.getJSONObject(i);
                        JSONObject totals = json.getJSONObject("totals");
                        String total = totals.getString("total");

                        map.put("total", totals.getString("total"));
                        map.put("tips", totals.getString("tips"));
                        map.put("tax", totals.getString("tax"));
                        map.put("sub_total", totals.getString("sub_total"));
                        map.put("service_charges", totals.getString("service_charges"));
                        map.put("paid", totals.getString("paid"));
                        map.put("other_charges", totals.getString("other_charges"));
                        map.put("items", totals.getString("items"));
                        map.put("due", totals.getString("due"));
                        map.put("discounts", totals.getString("discounts"));

                        ticket.setTotals(map);

                        table.add(ticket);

                        i++;
                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                }

            }
            @Override
            public void onFailure(int statusCode, Header[] headers, String response, Throwable throwable) {
                // Do something with the response
                System.out.println("ERROR: " + response.toString());
            }
        });

    }
}
