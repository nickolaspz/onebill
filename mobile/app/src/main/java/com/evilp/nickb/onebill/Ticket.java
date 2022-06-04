package com.evilp.nickb.onebill;

import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

/**
 * Created by nickb on 2017-08-15.
 */

public class Ticket {
    public Totals totals;
    public ArrayList<Item> items = new ArrayList<Item>();

    public void setTotals(HashMap<String, String> map) {
        this.totals = new Totals();

        totals.setTotal(map.get("total"));
        totals.setTips(map.get("tips"));
        totals.setTax(map.get("tax"));
        totals.setDiscounts(map.get("discounts"));
        totals.setItems(map.get("items"));
        totals.setOther_charges(map.get("other_charges"));
        totals.setPaid(map.get("paid"));
        totals.setDue(map.get("due"));
        totals.setSub_total(map.get("subtotal"));
    }

    public Totals getTotals() {
        return this.totals;
    }

    public void addItem(Item item) {
        this.items.add(item);
    }

    public ArrayList<Item> getItems() {
        return this.items;
    }
}