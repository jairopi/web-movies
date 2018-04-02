import java.net.*;
import java.io.*;
serverSocket = ServerSocket(4450);
display('Iniciando servidor');
try 
    while(1)
        socket = serverSocket.accept();
        display('Nueva conexion entrante');
        in = BufferedReader(InputStreamReader(socket.getInputStream()));
        %Leemos el id del usuario
        iduser = char(in.readLine());
        idu = iduser(1:1);
        funcstr = sprintf('filtrado(%s)',char(idu));
        disp(funcstr);
        %Codigo que atiende la peticion
        %Evaluamos la funcion que nos dice el cliente
        status=eval(char(funcstr));
        %Devolvemos un valor de estado y cerramos
        disp(status);

        %Restablecemos el path
        userpath('reset');
        display('cerrando conexion con cliente');
        socket.close()
    end
    
catch e
    e.message
    if(isa(e, 'matlab.exception.JavaException'))
        ex = e.ExceptionObject;
        ex.printStackTrace;
    end
    display('excepcion')
    socket.close();
    serverSocket.close();
end
serverSocket.close();
