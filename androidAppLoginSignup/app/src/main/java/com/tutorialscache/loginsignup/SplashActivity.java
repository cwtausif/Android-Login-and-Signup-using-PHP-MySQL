package com.tutorialscache.loginsignup;

import android.content.Intent;
import android.os.Bundle;

import java.util.Timer;
import java.util.TimerTask;

public class SplashActivity extends MainActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        context = this;
        init();
        setContentView(R.layout.activity_splash);

        // 5 seconds pause on splash page
        Timer timer = new Timer();
        timer.schedule(new TimerTask() {
            @Override
            public void run() {
                if(isLoggedIn()){
                    //Redirect to home page
                    intent = new Intent(context,HomeActivity.class);
                    startActivity(intent);
                    finish();
                }else{
                    //Redirect to Login Page
                    intent = new Intent(context,LoginActivity.class);
                    startActivity(intent);
                    finish();
                }
            }
        },5000);

    }
}
