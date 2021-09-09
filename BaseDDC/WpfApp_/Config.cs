using DDC_App;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Runtime.InteropServices;
using System.Text;
using System.Threading.Tasks;

namespace WpfApp_
{
    public static class Config
    {
        public static string Connection { get; private set; }
        private static string _path { get; set; }
        private static IniParser _iniPasrser;

        public static void LoadConfig()
        {
            _path = @"config.ini";
            _iniPasrser = new IniParser(_path);

            string adress = _iniPasrser.GetSetting("ServerConfig", "Adress");
            string port = _iniPasrser.GetSetting("ServerConfig", "Port");
            if(adress == null || port == null )
            {
                adress = "109.254.94.229";
                port = "17101";
                _iniPasrser.AddSetting("ServerConfig", "Adress", "109.254.94.229");
                _iniPasrser.AddSetting("ServerConfig", "Port", "17101");
                _iniPasrser.SaveSettings();
            }
            Connection = String.Format("http://{0}:{1}", adress, port);

        }
    }
}
