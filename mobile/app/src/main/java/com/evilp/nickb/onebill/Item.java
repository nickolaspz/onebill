package com.evilp.nickb.onebill;

/**
 * Created by nickb on 2017-08-20.
 */

public class Item {
    String id;
    String name;
    String price;
    String quantity;
    String sent;
    String sent_at;
    String commentvar;

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getPrice() {
        return price;
    }

    public void setPrice(String price) {
        this.price = price;
    }

    public String getQuantity() {
        return quantity;
    }

    public void setQuantity(String quantity) {
        this.quantity = quantity;
    }

    public String getSent() {
        return sent;
    }

    public void setSent(String sent) {
        this.sent = sent;
    }

    public String getSent_at() {
        return sent_at;
    }

    public void setSent_at(String sent_at) {
        this.sent_at = sent_at;
    }

    public String getCommentvar() {
        return commentvar;
    }

    public void setCommentvar(String commentvar) {
        this.commentvar = commentvar;
    }
}
