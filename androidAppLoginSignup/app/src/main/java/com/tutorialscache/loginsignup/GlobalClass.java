package com.tutorialscache.loginsignup;



import android.app.Application;

public class GlobalClass extends Application {
    public static final String BASE_URL = "http://192.168.18.8:8888/androidApp/";
//    public static final String BASE_URL = "http:/localhost:8888/androidApp/api.php";

    private static GlobalClass singleton;

    @Override
    public void onCreate() {
        super.onCreate();
        singleton = this;
    }

    public static GlobalClass getInstance() {
        return singleton;
    }
}
