package com.evilp.nickb.onebill;

/**
 * Created by nickb on 2017-08-15.
 */

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentStatePagerAdapter;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import cz.msebera.android.httpclient.Header;

public class ScreenSlidePagerActivity extends FragmentActivity {

    private List<Ticket> table;
    /**
     * The number of pages (wizard steps) to show in this demo.
     */
    private static int NUM_PAGES = 0;

    /**
     * The pager widget, which handles animation and allows swiping horizontally to access previous
     * and next wizard steps.
     */
    private ViewPager mPager;

    /**
     * The pager adapter, which provides the pages to the view pager widget.
     */
    private PagerAdapter mPagerAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.screen_slide);

        RestApiCall rac = new RestApiCall();
        rac.exec();
    }

    @Override
    public void onBackPressed() {
        if (mPager.getCurrentItem() == 0) {
            // If the user is currently looking at the first step, allow the system to handle the
            // Back button. This calls finish() on this activity and pops the back stack.
            super.onBackPressed();
        } else {
            // Otherwise, select the previous step.
            mPager.setCurrentItem(mPager.getCurrentItem() - 1);
        }
    }

    /**
     * A simple pager adapter that represents 5 ScreenSlidePageFragment objects, in
     * sequence.
     */
    private class ScreenSlidePagerAdapter extends FragmentStatePagerAdapter {
        public ScreenSlidePagerAdapter(FragmentManager fm) {
            super(fm);
        }

        @Override
        public Fragment getItem(int position) {

            Ticket t = table.get(position);

            ScreenSlidePageFragment fragment = new ScreenSlidePageFragment();
            Bundle args = new Bundle();
            args.putString("Total", t.getTotals().getTotal());
            args.putString("SubTotal", t.getTotals().getSub_total());
            args.putString("Tax", t.getTotals().getTax());
            args.putString("ServiceCharges", t.getTotals().getService_charges());

            args.putSerializable("items", t.getItems());

            fragment.setArguments(args);
            return fragment;
        }

        @Override
        public int getCount() {
            return NUM_PAGES;
        }
    }

    private class RestApiCall {

        public void exec () {
            RequestParams params = new RequestParams();
            params.put("location", "iq74jeMT");
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

                    table = new ArrayList<Ticket>();

                    try {
                        int i = 0;
                        while (i < response.length()) {
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

                            JSONArray items = json.getJSONArray("items");
                            for (int k = 0; k < items.length(); k++) {
                                JSONObject jsonItem = items.getJSONObject(k);
                                Item item = new Item();
                                item.setId(jsonItem.getString("id"));
                                item.setName(jsonItem.getString("name"));
                                item.setPrice(jsonItem.getString("price"));
                                item.setQuantity(jsonItem.getString("quantity"));
                                item.setCommentvar(jsonItem.getString("commentvar"));
                                item.setSent(jsonItem.getString("sent"));
                                item.setSent_at(jsonItem.getString("sent_at"));
                                ticket.addItem(item);
                            }

                            table.add(ticket);

                            i++;
                        }

                        NUM_PAGES = response.length();

                        // Instantiate a ViewPager and a PagerAdapter.
                        mPager = (ViewPager) findViewById(R.id.pager);
                        mPagerAdapter = new ScreenSlidePagerAdapter(getSupportFragmentManager());
                        mPager.setAdapter(mPagerAdapter);

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
}
