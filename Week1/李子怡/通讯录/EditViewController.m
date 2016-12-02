//
//  EditViewController.m
//  通讯录
//
//  Created by apple on 2016/10/6.
//  Copyright © 2016年 modouhe. All rights reserved.
//

#import "EditViewController.h"
#import <CoreData/CoreData.h>
#import "People+CoreDataProperties.h"


@interface EditViewController ()<UIImagePickerControllerDelegate,UINavigationControllerDelegate>

@property (weak, nonatomic) IBOutlet UITextField *nameField;
@property (weak, nonatomic) IBOutlet UITextField *phoneField;
@property (weak, nonatomic) IBOutlet UITextField *qqField;
@property (weak, nonatomic) IBOutlet UIButton *saveBtn;
- (IBAction)saveAction:(id)sender;
@property (weak, nonatomic) IBOutlet UIBarButtonItem *edit;
- (IBAction)editAction:(UIBarButtonItem *)sender;
- (IBAction)choose_image:(id)sender;
@property (weak, nonatomic) IBOutlet UIImageView *image_view;
@property (weak, nonatomic) UIImage *image;
@property (strong, nonatomic) NSManagedObjectContext * managedObjectContext;

@end

@implementation EditViewController

#pragma mark - 获取本应用的上下文对象
-(NSManagedObjectContext *)applicationManagedObjectContext{
    UIApplication * application = [UIApplication sharedApplication];
    id delegate = application.delegate;
    //返回应用的上下文对象
    return [delegate managedObjectContext];
}

- (void)viewDidLoad {
    [super viewDidLoad];
    self. managedObjectContext = [self applicationManagedObjectContext];


    /* self. nameField.text ;
    self. phoneField.text;
    self. qqField.text;*/
    
    
     [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:(UITextFieldTextDidChangeNotification) object:self. nameField];
     
     [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:(UITextFieldTextDidChangeNotification) object:self. phoneField];
     
     [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:(UITextFieldTextDidChangeNotification) object:self. qqField];
     }
     
     -(void) textChange{
     self. saveBtn. enabled = (self. nameField. text. length && (self. phoneField. text. length || self. qqField. text. length));
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
 #pragma mark - Navigation
 
 // In a storyboard-based application, you will often want to do a little preparation before navigation
 - (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
 // Get the new view controller using [segue destinationViewController].
 // Pass the selected object to the new view controller.
 }
 */

- (IBAction)saveAction:(id)sender {

   
    [self. navigationController popViewControllerAnimated:YES ];
    
    //获取一个实体托管对象 people
    People * people = [NSEntityDescription insertNewObjectForEntityForName:NSStringFromClass([People class]) inManagedObjectContext:self.managedObjectContext];
    
    //为托管对象设置属性
    people. name = self. nameField.text;
    people. phone = self. phoneField.text;
    people. qq = self. qqField.text;
    
    people. image = UIImagePNGRepresentation(_image);
    
    //上下文对象保存
    NSError * error;
    if (![self.managedObjectContext save:&error]){
        NSLog(@"%@",[error localizedDescription]);
    }
    
    
    
    
    
    /*if ([self.delegate respondsToSelector:@selector(editViewController:didSaveContact:)]){
     self. contactModel. name = self. nameField. text;
     self. contactModel. phone = self. phoneField. text;
     self. contactModel. qq = self. qqField. text;
     [self. delegate editViewController:self didSaveContact:self.contactModel];
     }*/
}
- (IBAction)editAction:(UIBarButtonItem *)sender {
    if (self. nameField. enabled){
        self. nameField. enabled = NO;
        self. phoneField. enabled = NO;
        self. qqField. enabled = NO;
        [self. view endEditing:YES];
        self. saveBtn. hidden = YES;
        sender.title = @"编辑";

    } else{
        self. nameField. enabled = YES;
        self. phoneField. enabled = YES;
        self. qqField. enabled = YES;
        [self. view endEditing:NO];
        self. saveBtn. hidden = NO;
        sender.title = @"取消";
    }
}

- (IBAction)choose_image:(id)sender {
    
    UIAlertController *alert = [UIAlertController alertControllerWithTitle:@"选择" message:nil preferredStyle:UIAlertControllerStyleActionSheet];
    
    [alert addAction:[UIAlertAction actionWithTitle:@"取消" style: UIAlertActionStyleCancel handler:nil]];
    
    //借鉴ZHGPhotoDemo.xcodeproj 与 simpleTable.xcodeproj 与https://my.oschina.net/joanfen/blog/134677
    
    UIAlertAction *cameralButton = [UIAlertAction actionWithTitle:@"相机" style:UIAlertActionStyleDefault handler:^(UIAlertAction * _Nonnull action) {
        
        if ([UIImagePickerController isSourceTypeAvailable:UIImagePickerControllerSourceTypeCamera]) {
            //图片资源来自相册
            //UIImagePickerControllerSourceType sourceType = UIImagePickerControllerSourceTypeCamera;
            UIImagePickerController *imageCameral = [[UIImagePickerController alloc] init];
            imageCameral.sourceType = UIImagePickerControllerSourceTypeCamera;
            imageCameral.cameraDevice = UIImagePickerControllerCameraDeviceRear;
            //设置选取代理
            imageCameral.delegate = self;
            //使用模态窗口显示相册
            [self presentViewController:imageCameral animated:YES completion:nil];
            
        }else {
            
            UIAlertController *alert = [UIAlertController alertControllerWithTitle:@"提示" message:@"该设备不支持照相功能" preferredStyle:UIAlertControllerStyleAlert];
            
            UIAlertAction *cancel = [UIAlertAction actionWithTitle:@"确定" style:UIAlertActionStyleCancel handler:nil];
            
            [alert addAction:cancel];
            
            [self presentViewController:alert animated:YES completion:nil];
        }
        
    }];
    
    
    
    
    UIAlertAction *photoButton =[UIAlertAction actionWithTitle:@"从相册中选取" style:UIAlertActionStyleDefault handler:^(UIAlertAction * _Nonnull action) {
        //图片资源来自相册
        //  UIImagePickerControllerSourceType sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
        UIImagePickerController *imagePhoto = [[UIImagePickerController alloc] init];
        imagePhoto. sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
        //设置选取代理
        imagePhoto. delegate = self;
        
        //使用模态窗口显示相册
        [self presentViewController:imagePhoto animated:YES completion:nil];
        
    }];
    
    [alert addAction:cameralButton];
    [alert addAction:photoButton];
    
    
    [self presentViewController:alert animated:YES completion:nil];
    
    
}

-(void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
{
    //NSLog(@"%@",info);
    //info：这个字典中放着图片的具体信息,通过这个字典的键可以获取图片
    
    //取出图片
    self. image = [info objectForKey:UIImagePickerControllerOriginalImage];//显示图片在图像视图中
    [self. image_view setImage: self. image];
    
    //关闭模态窗口
    [picker dismissViewControllerAnimated:YES completion:nil];
}


@end

