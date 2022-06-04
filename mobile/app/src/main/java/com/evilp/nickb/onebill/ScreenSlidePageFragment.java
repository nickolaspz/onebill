package com.evilp.nickb.onebill;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by nickb on 2017-08-15.
 */

public class ScreenSlidePageFragment extends Fragment {

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        ViewGroup rootView = (ViewGroup) inflater.inflate(R.layout.ticket_slide, container, false);

        ListView lv = (ListView) rootView.findViewById(R.id.items);

        TextView totalText = (TextView) rootView.findViewById(R.id.text);
        Bundle args = getArguments();
        String total = args.getString("Total");

        ArrayList<Item> items = (ArrayList<Item>) args.getSerializable("items");

        List values = new ArrayList();
        for (int i = 0; i < items.size(); i++) {
            Item item = items.get(i);
            System.out.println(item.getName());
            values.add(item.getName());
            System.out.println(item.getPrice());
        }

        values.add("poontang");

        ArrayAdapter<String> adapter = new ArrayAdapter<String>(getActivity(),
                android.R.layout.simple_list_item_1,
                values);

        lv.setAdapter(adapter);

        return rootView;
    }

}