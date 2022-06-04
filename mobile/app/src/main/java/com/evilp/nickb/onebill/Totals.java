package com.evilp.nickb.onebill;

/**
 * Created by nickb on 2017-08-15.
 */

public class Totals {
    public String total;
    public String tips;
    public String tax;
    public String sub_total;
    public String service_charges;
    public String paid;
    public String other_charges;
    public String items;
    public String due;
    public String discounts;

    public void setTotal(String total)
    {
        this.total = total;
    }

    public void setTips(String tips) {
        this.tips = tips;
    }

    public void setTax(String tax) {
        this.tax = tax;
    }

    public void setSub_total(String sub_total) {
        this.sub_total = sub_total;
    }

    public void setService_charges(String service_charges) {
        this.service_charges = service_charges;
    }

    public void setPaid(String paid) {
        this.paid = paid;
    }

    public void setOther_charges(String other_charges) {
        this.other_charges = other_charges;
    }

    public void setItems(String items) {
        this.items = items;
    }

    public void setDue(String due) {
        this.due = due;
    }

    public void setDiscounts(String discounts) {
        this.discounts = discounts;
    }

    public String getTotal() {
        return total;
    }

    public String getTips() {
        return tips;
    }

    public String getTax() {
        return tax;
    }

    public String getSub_total() {
        return sub_total;
    }

    public String getService_charges() {
        return service_charges;
    }

    public String getPaid() {
        return paid;
    }

    public String getOther_charges() {
        return other_charges;
    }

    public String getItems() {
        return items;
    }

    public String getDue() {
        return due;
    }

    public String getDiscounts() {
        return discounts;
    }
}
