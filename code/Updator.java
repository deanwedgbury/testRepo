
import java.sql.*;

public class Updator{

	// A connection to the database  
	Connection connection;
	  
	// Statement to run queries
	Statement sql;
	  
	// Prepared Statement
	PreparedStatement ps;
	  
	// Resultset for the query
	ResultSet rs;
	
	public Updator(){}

	//establish a connection to be used for this session. Returns true if connection is sucessful
	public boolean connectDB(String connection_name, String username, String password){
		try {
      		connection = DriverManager.getConnection(connection_name, username, password); 
    	} catch (SQLException e) {
 
      		System.out.println("Connection Failed! Check output console");
      		e.printStackTrace();
      		return false;
    	}

    	if (connection == null) {
      		System.out.println("Failed to make connection!");
      		return false;
    	}
    	return true;
	}

	  //Closes the connection. Returns true if closure was sucessful
	  public boolean disconnectDB(){

	    try {
	      if (connection != null)
	        connection.close();
	    }
	    catch(SQLException e) {
	      return false;    
	    }
	    return true;
	  }

  	public boolean updateDB(int iteration, int moisture){
  		String sqlText;

	  	try {
	  		//we will prepare the statement later
	      sqlText = "INSERT INTO observed_data VALUES(" + iteration + ", " + moisture + ");";
	      rs = sql.executeQuery(sqlText);
	    }
	    catch (SQLException e) {
	      return false;
	    }
  	}

	public static void main(String[] args){
		//if(args.length == 0){

		//}
		int iteration = args[1];
		int moisture = args[2];
		Updator u = new Updator();
		u.connectDB("jdbc:postgresql://mcsdb.utm.utoronto.ca:5432/chanande_309", "chanande", "40156");
		u.updateDB(iteration, moisture);
		u.disconnectDB();

	}
}