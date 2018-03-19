

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.HttpURLConnection.*;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.nio.charset.StandardCharsets;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.StringJoiner;

//import javax.net.ssl.HttpsURLConnection;
import java.net.HttpURLConnection;

public class Update {//extends AsyncTask<String, Void, String> {
    static String server_response;

    /*
    @Override
    protected String doInBackground(String... strings) {
    */
    protected static String requestDb(String endpoint, String reqType){
        URL url;
        HttpURLConnection httpsConnection = null;
        String websitePath = "http://cslinux.utm.utoronto.ca:10511/";
        //String query = "select * from appuser;";
        //String queryParams = "stuff";


        try {

            //########################## Connect #######################

            url = new URL(websitePath + endpoint);
            httpsConnection = (HttpURLConnection) url.openConnection();
            httpsConnection.setRequestMethod(reqType);
            //httpsConnection.setRequestProperty("Content-length", "0");

            httpsConnection.setDoInput(true);
            httpsConnection.setDoOutput(true); //comment this for get
            //httpsConnection.setRequestProperty("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
            httpsConnection.setRequestProperty("Content-Type", "application/json; charset=UTF-8");
            httpsConnection.setRequestProperty("Accept", "application/json");



            //################ Constructing Output ###################

            /*
            Map<String,String> arguments = new HashMap<>();
            arguments.put("myquery", query);
            //arguments.put("myqparams", queryParams);

            
            StringJoiner sj = new StringJoiner("&");
            for(Map.Entry<String,String> entry : arguments.entrySet())
                sj.add(URLEncoder.encode(entry.getKey(), "UTF-8") + "="
                        + URLEncoder.encode(entry.getValue(), "UTF-8"));
            byte[] out = sj.toString().getBytes(StandardCharsets.UTF_8);
            

            try(OutputStream os = httpsConnection.getOutputStream()) {
                os.write(out);
            }
            */


            //String data = "{\"username\": \"" + stringData + "\"}";
            //no url encoding needed here
            String data = "{\"username\": \"a\", \"password\": \"a\"}";

            //outputStream.write((data).getBytes("UTF-8"));
            byte[] out = (data).getBytes(StandardCharsets.UTF_8);

            if (reqType == "POST"){
                httpsConnection.setFixedLengthStreamingMode(out.length);
            }
            

            httpsConnection.connect();
            System.out.println("Connected.");

            //Response code is OK here

            if (reqType == "POST"){
                OutputStream outputStream = httpsConnection.getOutputStream();


                

                //OutputStreamWriter out = new OutputStreamWriter(outputStream);

                outputStream.write(out);
                outputStream.flush();
                //outputStream.close();

                System.out.println("Sending Data.");
            }

            // ##################### Response ###############################

            int responseCode = httpsConnection.getResponseCode();
            if (responseCode == HttpURLConnection.HTTP_OK) {
                server_response = readStream(httpsConnection.getInputStream());
                System.out.println("Server response: " + server_response);
            } else {
                 System.out.println("Response Code:" + responseCode);
                 System.out.println(httpsConnection.getErrorStream());
            }
            

        } catch (MalformedURLException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }

        return null;
    }


    // Converting InputStream to String
    private static String readStream(InputStream in) {
        BufferedReader reader = null;
        StringBuffer response = new StringBuffer();
        try {
            reader = new BufferedReader(new InputStreamReader(in));
            String line = "";
            while ((line = reader.readLine()) != null) {
                response.append(line);
            }
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            if (reader != null) {
                try {
                    reader.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        }
        return response.toString();
    }

    public static void main(String[] args){
        System.out.println("Testing getScores.");
        requestDb("api/getScores", "GET");
        System.out.println("Testing login.");
        requestDb("api/login", "POST");
    }
}